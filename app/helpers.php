<?php

if (!function_exists('generate_meta')) {
    /**
     * generate response meta according to status
     * @param  mixed $status
     * @param  string $errorMessage
     * @return array
     */
    function generate_meta($status, $errorMessage = 'failure')
    {
        if (empty($status) || $status === 'failure' || (method_exists($status, 'isEmpty') && $status->isEmpty())) {
            return [
                'code' => 0,
                'message' => $errorMessage
            ];
        }

        return [
            'code' => 1,
            'message' => 'success'
        ];
    }
}