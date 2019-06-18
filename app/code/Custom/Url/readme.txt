Task

Description

    Необходимо кастомизировать урлы категорий и товаров.
    Добавить после доменного имени строку “shop/” для товара и
    “shop/category” для категории.
    Оформить отдельным модулем.

Result

    Module Content

        Custom
        - Url
        -- etc
        --- di.xml
        --- module.xml
        -- Plugin
        --- CategoryUrl.php
        --- ProductUrl.php
        -- readme.txt
        -- registration.php

    Для того, чтобы могли появиться custom url необходимо сделать следующее -

        - product

            1 Admin set anchor for category -
                Catalog -> Categories -> <select category> -> Display Settings -> Anchor -> yes
            2 Save changed
            3 Clean cache
            4 Reload browser frontend

        - category

            1 Admin change url_key for category -
                Catalog -> Categories -> <select category> -> Search Engine Optimization -> URL Key -> change custom
            2 Save changed
            3 Admin return default value url_key back -
                Catalog -> Categories -> <select category> -> Search Engine Optimization -> URL Key -> change value back
            4 Save changed
            3 Clean cache
            4 Reload browser frontend
