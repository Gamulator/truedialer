<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Provider model
 */
class Provider
{
    const TYPE_CONTRACTED = 0;
    const TYPE_NON_CONTRACTED = 1;

    const SUBJECT_PERSON = 0;
    const SUBJECT_COMPANY = 1;

    const STATUS_CONTACTING = 0;
    const STATUS_TALKED = 1;
    const STATUS_ASSESSMENT = 2;
    const STATUS_CONTRACT = 3;
    const STATUS_CANCEL = 4;

    /**
     * Internal method to create fake data.
     *
     * @return array
     */
    public static function generateProviders()
    {
        $faker = \Faker\Factory::create();

        $data = [];
        for ($i = 0; $i < 25; $i++) {

            $type = rand(self::SUBJECT_PERSON, self::SUBJECT_COMPANY);

                $data[] = [
                'contracted' => rand(self::TYPE_CONTRACTED, self::TYPE_NON_CONTRACTED),
                'type' => $type,
                'name' => $type == self::SUBJECT_PERSON ? $faker->name : $faker->company,
                'email' => $faker->email,
                'phone' => $faker->phoneNumber,
                'id' => rand(1000, 9999),
                'status' => rand(self::STATUS_CONTACTING, self::STATUS_CANCEL),
            ];
        }

        return $data;
    }
}
