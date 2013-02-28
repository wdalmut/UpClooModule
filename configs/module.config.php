<?php
return array(
    'di' => array(
        'definition' => array(
            'class' => array(
                'UpCloo_Manager' => array(
                    'setClient' => array(
                        'shared' => array(
                            'type' => 'UpCloo_Client_ClientInterface',
                            'required' => true
                        )
                    )
                )
            )
        ),
        'instance' => array(
            'UpCloo_Manager' => array(
                'injections' => array(
                    'setClient' => array('shared' => 'UpCloo_Client_UpCloo'
                    )
                )
            )
        )
    ),
    'service_manager' => array(
        'factories' => array(
            'upcloo' => function(\Zend\ServiceManager\ServiceLocatorInterface $sl) {
                $config = $sl->get("Config");
                $sitekey = $config["upcloo"]["sitekey"];

                $upcloo = $sl->get("di")->get("UpCloo_Manager");
                $upcloo->setSitekey($sitekey);

                return $upcloo;
            },
            'UpClooModule\SdkListener' => function ($sm) {
                $config = $sm->get("Config");
                return new \UpClooModule\Listener\SdkListener($sm->get('ViewRenderer'), $config["upcloo"]);
            },
        )
    ),
    'upcloo' => array(
        'sitekey' => '',
        'auto_apply' => true,
        'route' => array()
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
