<?php

namespace modava\location;

use yii\base\BootstrapInterface;
use Yii;
use yii\base\Event;
use \yii\base\Module;
use yii\web\Application;
use yii\web\Controller;

/**
 * location module definition class
 */
class LocationModule extends Module implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'modava\location\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        // custom initialization code goes here
        $this->registerTranslations();
        parent::init();
        Yii::configure($this, require(__DIR__ . '/config/location.php'));
        $handler = $this->get('errorHandler');
        Yii::$app->set('errorHandler', $handler);
        $handler->register();
        $this->layout = 'location';
    }



    public function bootstrap($app)
    {
        $app->on(Application::EVENT_BEFORE_ACTION, function () {

        });
        Event::on(Controller::class, Controller::EVENT_BEFORE_ACTION, function (Event $event) {
            $controller = $event->sender;
        });
    }

    public function registerTranslations()
    {
        Yii::$app->i18n->translations['location/messages/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en',
            'basePath' => '@modava/location/messages',
            'fileMap' => [
                'location/messages/location' => 'location.php',
            ],
        ];
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('location/messages/' . $category, $message, $params, $language);
    }
}
