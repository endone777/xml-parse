<?php

namespace App\Services;

use App\Models\Offer;

class OfferUpdateService {

    private string $file = 'data.xml';
    private array $storage;
    private array $duplicate;

    /**
     * Создание/Обновление данных в БД
     * @param array $data
     * @return void
     */
    public function upsertData(array $data)
    {
        Offer::upsert($data, ['id'] , [
            'id',
            'mark' ,
            'model' ,
            'generation' ,
            'year' ,
            'run' ,
            'color' ,
            'body-type' ,
            'engine-type' ,
            'transmission' ,
            'gear-type',
            'generation_id',
            'deleted_at',
        ]);
    }

    /**
     * Получине данных хранилища
     * @return array
     */
    public function getStorageData()
    {
        return $this->storage;
    }

    /**
     * Мягкое удаление дубликатов в БД
     * @return $this
     */
    public function deleteDuplicates()
    {
        if(count($this->duplicate))
        {
            Offer::whereIn('id' , $this->duplicate)->delete();
        }
        return $this;
    }

    /**
     * Расхождение XML файла с БД
     * @return $this
     */
    public function difference(): static
    {
        $offersIds = Offer::all('id')->pluck('id')->toArray();

        $ids = array_map(
            function($item)
            {
                return (int) $item['id'];
            },
            $data = $this->storage
        );

        $this->duplicate = array_diff($offersIds ,$ids);

        return $this;

    }

    /**
     * Создание масива для передачи в БД
     * @return $this
     */
    public function createOffersArray(): static
    {
        $xml = $this->parse($this->file);

        $i = 0;
        foreach ($xml['offers'] as $items)
        {
            foreach ($items as $item)
            {
                foreach ($item as $k => $offer)
                {
                    $this->storage[$i][$k] = is_array($offer) ? null : $offer;
                }
                $this->storage[$i]['deleted_at'] = null;
                $i++;
            }
        }

        return $this;

    }

    /**
     * Проверка существования файла при входном параметре --file
     * @param string $path
     * @return $this
     */
    public function fileExist(string $path): static
    {

        if(file_exists($path))
        {
            $this->file = $path;
        }

        return $this;

    }

    /**
     * Парсинг XML файла
     * @param $file
     * @return mixed
     */
    private function parse($file): mixed
    {

        $xml = simplexml_load_file($file);

        return json_decode(json_encode((array) $xml), true);

    }

}
