<?php
if (isset($field['raw'])) {
    $string = $field['raw'];
} else {
    $value = Hash::extract($data, $field['path']);
    $string = empty($value[0]) ? '' : h($value[0]);
}
if (!empty($field['url'])) {
    if (!empty($field['url_vars'])) {
        if (!is_array($field['url_vars'])) {
            $field['url_vars'] = [$field['url_vars']];
        }
        foreach ($field['url_vars'] as $k => $path) {
            $field['url'] = str_replace('{{' . $k . '}}', Hash::extract($data, $path)[0], $field['url']);
            $temp = explode(':', $field['url']);
            if (!in_array(strtolower($temp[0]), ['http', 'https'])) {
                $field['url'] = '#';
                $string = 'Malformed URL - invalid protocol (' . h($temp[0]) . ':)';
            }
        }
    }
    $string = sprintf(
        '<a href="%s">%s</a>',
        h($field['url']),
        $string
    );
}
echo $string;
