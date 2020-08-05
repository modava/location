<?php

namespace modava\location\models\table;

use cheatsheet\Time;
use modava\location\models\query\LocationWardQuery;
use Yii;
use yii\db\ActiveRecord;

class LocationWardTable extends \yii\db\ActiveRecord
{
    const STATUS_DISABLED = 0;
    const STATUS_PUBLISHED = 1;

    public static function tableName()
    {
        return 'location_ward';
    }

    public static function find()
    {
        return new LocationWardQuery(get_called_class());
    }

    public function getDistrictHasOne()
    {
        return $this->hasOne(LocationDistrictTable::class, ['id' => 'DistrictID']);
    }

    public function afterDelete()
    {
        $cache = Yii::$app->cache;
        $keys = [
            'redis-location-ward-get-ward-by-id-' . $this->id . '-' . $this->language,
            'redis-location-ward-get-ward-by-district-' . $this->DistrictID . '-' . $this->language
        ];
        foreach ($keys as $key) {
            $cache->delete($key);
        }
        return parent::beforeDelete(); // TODO: Change the autogenerated stub
    }

    public function afterSave($insert, $changedAttributes)
    {
        $cache = Yii::$app->cache;
        $keys = [
            'redis-location-ward-get-ward-by-id-' . $this->id . '-' . $this->language,
            'redis-location-ward-get-ward-by-district-' . $this->DistrictID . '-' . $this->language
        ];
        foreach ($keys as $key) {
            $cache->delete($key);
        }
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }

    public static function getWardById($id, $language = null)
    {
        $cache = Yii::$app->cache;
        $key = 'redis-location-ward-get-ward-by-id-' . $id . '-' . $language;
        $data = $cache->get($key);
        if ($data == false) {
            $data = self::find()->where(['id' => $id, 'language' => $language ?: Yii::$app->language])->published()->one();
            $cache->set($key, $data);
        }
        return $data;
    }

    public static function getWardByDistrict($district = null, $language = null)
    {
        $cache = Yii::$app->cache;
        $key = 'redis-location-ward-get-ward-by-district-' . $district . '-' . $language;
        $data = $cache->get($key);
        if ($data == false) {
            $query = self::find()->select(["*", "CONCAT(Type, ' ', name) AS name"])->where(['DistrictID' => $district, 'language' => $language ?: Yii::$app->language])->published()->sortDescById();
            $data = $query->all();
            $cache->set($key, $data);
        }
        return $data;
    }
}
