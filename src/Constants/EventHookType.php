<?php


namespace AmoCRM\Constants;

/**
 * Типы событий уведомлений
 * @package AmoCRM\Constants
 */
class EventHookType
{
    /**
     * Добавлена сделка
     */
    const ADD_LEAD = 'add_lead';

    /**
     * Добавлен контакт
     */
    const ADD_CONTACT = 'add_contact';

    /**
     * Добавлена компания
     */
    const ADD_COMPANY = 'add_company';

    /**
     * Добавлен покупатель
     */
    const ADD_CUSTOMER = 'add_customer';

    /**
     * Добавлена задача
     */
    const ADD_TASK = 'add_task';

    /**
     * Сделка изменена
     */
    const UPDATE_LEAD = 'update_lead';

    /**
     * Контакт изменён
     */
    const UPDATE_CONTACT = 'update_contact';

    /**
     * Компания изменена
     */
    const UPDATE_COMPANY = 'update_company';

    /**
     * Покупатель изменен
     */
    const UPDATE_CUSTOMER = 'update_customer';

    /**
     * Задача изменена
     */
    const UPDATE_TASK = 'update_task';

    /**
     * Удалена сделка
     */
    const DELETE_LEAD = 'delete_lead';

    /**
     * Удалён контакт
     */
    const DELETE_CONTACT = 'delete_contact';

    /**
     * Удалена компания
     */
    const DELETE_COMPANY = 'delete_company';

    /**
     * Удален покупатель
     */
    const DELETE_CUSTOMER = 'delete_customer';

    /**
     * Удалена задача
     */
    const DELETE_TASK = 'delete_task';

    /**
     * У сделки сменился статус
     */
    const STATUS_LEAD = 'status_lead';

    /**
     * У сделки сменился ответственный
     */
    const RESPONSIBLE_LEAD = 'responsible_lead';

    /**
     * У контакта сменился ответственный
     */
    const RESPONSIBLE_CONTACT = 'responsible_contact';

    /**
     * У компании сменился ответственный
     */
    const RESPONSIBLE_COMPANY = 'responsible_company';

    /**
     * У покупателя сменился ответственный
     */
    const RESPONSIBLE_CUSTOMER = 'responsible_customer';

    /**
     * У задачи сменился ответственный
     */
    const RESPONSIBLE_TASK = 'responsible_task';

    /**
     * Сделка восстановлена из корзины
     */
    const RESTORE_LEAD = 'restore_lead';

    /**
     * Контакт восстановлен из корзины
     */
    const RESTORE_CONTACT = 'restore_contact';

    /**
     * Компания восстановлена из корзины
     */
    const RESTORE_COMPANY = 'restore_company';

    /**
     * Примечание добавлено в сделку
     */
    const NOTE_LEAD = 'note_lead';

    /**
     * Примечание добавлено в контакт
     */
    const NOTE_CONTACT = 'note_contact';

    /**
     * Примечание добавлено в компанию
     */
    const NOTE_COMPANY = 'note_company';

    /**
     * Примечание добавлено в покупателя
     */
    const NOTE_CUSTOMER = 'note_customer';
}