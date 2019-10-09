<?php

namespace AmoCRM\Exceptions;


class AmoCRMNotesException extends AmoCRMAPIException
{
   protected $errors = array(
      218 => 'Добавление событий: пустой массив',
      221 => 'Список событий: требуется тип',
      222 => 'Добавление/Обновление событий: пустой запрос',
      223 => 'Добавление/Обновление событий: неверный запрашиваемый метод',
      224 => 'Обновление событий: пустой массив',
      225 => 'Обновление событий: события не найдены',
      226 => 'Добавление событий: элемент события данной сущности не найден',
      232 => 'Добавление событий: ID элемента или тип элемента пустые либо некорректные',
      233 => 'Добавление событий: по данному ID элемента не найдены некоторые контакты',
      234 => 'Добавление событий: по данному ID элемента не найдены некоторые сделки',
      244 => 'Добавление событий: недостаточно прав для добавления события',
   );
}
