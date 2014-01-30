<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'upcloo' => "UpClooModule\\Service\\UpClooFactory",
            "upcloo.manager" => "UpClooModule\\Service\\UpClooManagerFactory",
            'UpClooModule\SdkListener' => "UpClooModule\\Service\\SdkListenerFactory",
        )
    ),
    'view_manager' => array(
        'template_map' => array(
            'upcloo_sdk_view' => __DIR__ . '/../view/sdk.js.phtml'
        )
    ),
    'view_helpers' => array(
      'invokables' => array(
         'upClooSdk' => 'UpClooModule\View\Helper\UpClooSdk',
         'upClooForSpiders' => 'UpClooModule\View\Helper\UpClooForSpiders',
      ),
   ),
);
