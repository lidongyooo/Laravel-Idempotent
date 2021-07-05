<?php

return [

    /**
     * 强制模式
     * forcible = true 将不需要前端传递唯一字符，否则请传递唯一字符
     * 关于字符生成算法请参考：Lidongyooo\Idempotent\IdempotentKeyGenerator
     */

    'forcible' => false,

    /**
     * 启用幂等的方法
     * GET、DELETE 的特性天然符合幂等要求
     */

    'methods' => [
        'POST' => [
            'save' => true, //缓存响应
            'save_ttl' => 86400 //缓存时间
        ],
        'PUT' => [
            'save' => false,
            'save_ttl' => 0
        ],
        'PATCH' => [
            'save' => false,
            'save_ttl' => 0
        ]
    ],

    /**
     * 需添加至请求头的字段名称
     */

    'header_name' => 'Idempotent-Key',

    /**
     * 如果当前请求是缓存的，会将此字段添加至响应首部中
     */

    'back_header_name' => 'Idempotent-Repeated'
];