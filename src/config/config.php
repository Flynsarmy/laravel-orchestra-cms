<?php

return array(

    /*
    |----------------------------------------------------------------------
    | Page permalinks
    |----------------------------------------------------------------------
    |
    | Slug format for Pages. Valid replacements include
    | {id}, {slug}
    |
    | For example cms/{slug} would result in a URL
    | /cms/my-page
    |
    | Default is {slug} which would result in a URL of /my-page
    |
    */
    'permalink' => '{slug}',

    /*
    |----------------------------------------------------------------------
    | Default Template content field view path
    |----------------------------------------------------------------------
    |
    | Path to view file containing the content a Template will have by
    | default on the 'New Template' page
    |
    */
    'default_template_content_view' => 'flynsarmy/orchestra-cms::backend.template.default_content',
);
