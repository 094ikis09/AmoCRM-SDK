<?php


namespace AmoCRM\Listeners;

use AmoCRM\Exceptions\AmoCRMException;

/**
 * Class Webhook
 *
 * Назначение и вызов callback при уведомлениях.
 *
 * Webhooks – это уведомление сторонних приложений посредством отправки уведомлений о событиях,
 * произошедших в amoCRM. Вы можете настроить HTTP адреса ваших приложений и связанные с ними
 * рабочие правила в настройках своего аккаунта, в разделе «API».
 *
 * @package AmoCRM\Listeners
 */
class Webhook
{
    private $hook_callback = array();

    /**
     * Добавление события на уведомление в список событий
     *
     * @param array $events массив событий
     * @param callable $callback Callback-функция
     * @return $this
     * @throws AmoCRMException
     */
    public function on(array $events, callable $callback)
    {
        foreach ($events as $event) {
            if (!is_string($event)) {
                throw new AmoCRMException('Invalid event name');
            }
            if (!isset($this->hook_callback[$event])) {
                $this->hook_callback[$event] = array();
            }
            $this->hook_callback[$event][] = $callback;
        }

        return $this;
    }


    public function listen()
    {
        ignore_user_abort(true);
        set_time_limit(0);
        ob_start();
        header('Connection: close');
        header('Content-Length: ' . ob_get_length());
        ob_end_flush();
        ob_flush();
        flush();

        if (!isset($_POST['account']['subdomain']) || empty($this->hook_callback)) {
            return false;
        }
        $data = $_POST;
        $domain = $data['account']['subdomain'];
        unset($data['account']);

        foreach ($data as $entityName => $entityData) {
            foreach ($entityData as $actionName => $actionData) {
                foreach ($actionData as $actionDatum) {
                    $type = $entityName;
                    switch ($entityName) {
                        case 'contacts':
                            $type = $actionDatum['type'];
                            break;
                        case 'leads':
                            $type = 'lead';
                            break;
                    }
                    $callback = $actionName . '_' . $type;
                    $id = isset($actionDatum['id']) ? $actionDatum['id'] : null;

                    $callbacks = isset($this->hook_callback[$callback]) ? $this->hook_callback[$callback] : array();
                    foreach ($callbacks as $callback) {
                        call_user_func($callback, $domain, $id, $actionDatum);
                    }
                }
            }
        }
        return true;
    }

}