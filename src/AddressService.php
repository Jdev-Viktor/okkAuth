<?php
/**
 * Created by Volodymyr <Terion> Kornilov (mail@terion.name)
 * Date: 15.07.17
 * Time: 15:40
 */

namespace jDev\OkkAuth;


use BadMethodCallException;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class AddressService implements Arrayable, \JsonSerializable, Jsonable
{
    /**
     * @var string|null
     */
    protected $country;
    /**
     * @var string|null
     */
    protected $country_code;
    /**
     * @var string|null
     */
    protected $state;
    /**
     * @var string|null
     */
    protected $city;
    /**
     * @var string|null
     */
    protected $district;
    /**
     * @var string|null
     */
    protected $street;
    /**
     * @var string|null
     */
    protected $building;
    /**
     * @var string|null
     */
    protected $apartment;
    /**
     * @var string|null
     */
    protected $postcode;
    /**
     * @var float|null
     */
    protected $lat;
    /**
     * @var float|null
     */
    protected $lon;

    public function __construct($data = [])
    {
        if (is_object($data)) {
            $data = (array)$data;
        }
        // generic implementation
        $this->country = $this->typeCast($data, 'country');
        $this->country_code = $this->typeCast($data, 'country_code');
        $this->state = $this->typeCast($data, 'state');
        $this->city = $this->typeCast($data, 'city');
        $this->district = $this->typeCast($data, 'district');
        $this->street = $this->typeCast($data, 'street');
        $this->building = $this->typeCast($data, 'building');
        $this->apartment = $this->typeCast($data, 'apartment');
        $this->postcode = $this->typeCast($data, 'postcode');
        $this->lat = $this->typeCast($data, 'lat');
        $this->lon = $this->typeCast($data, 'lon');
    }

    protected function typeCast($value, $prop) {
        if (is_array($value)) {
            $value = array_get($value, $prop);
        }

        if (is_null($value)) return null;

        switch ($prop) {
            case 'lat':
            case 'lon':
                $v = floatval($value);
        }

        $v = (string) $value;

        return empty($v) ? null : $v;
    }

    public function exists(): bool
    {
        return count(array_filter($this->toArray())) > 0;
    }

    public function getCountry():? string
    {
        return $this->country;
    }

    public function getCountryCode():? string
    {
        return $this->country_code;
    }

    public function getState():? string
    {
        return $this->state;
    }

    public function getCity():? string
    {
        return $this->city;
    }

    public function getDistrict():? string
    {
        return $this->district;
    }

    public function getStreet():? string
    {
        return $this->street;
    }

    public function getBuilding():? string
    {
        return $this->building;
    }


    public function getApartment():? string
    {
        return $this->apartment;
    }

    public function getPostcode():? string
    {
        return $this->postcode;
    }

    public function getLat():? float
    {
        return $this->lat;
    }

    public function getLon():? float
    {
        return $this->lon;
    }

    public function getPostalAddress(): string
    {
        return implode(', ', array_filter(array_except($this->toArray(), ['lat', 'lon', 'country_code'])));
    }

    public function getFullAddress(): string
    {
        return implode(', ', array_filter(array_except($this->toArray(), ['lat', 'lon', 'postcode', 'country_code'])));
    }

    public function getLocalAddress(): string
    {
        return implode(', ', array_filter(array_except($this->toArray(), ['country', 'state', 'lat', 'lon', 'postcode', 'country_code'])));
    }

    public function getGeocodeQuery(): string
    {
        $props = ['country', 'state', 'city', 'street', 'building'];
        $parts = array_only($this->toArray(), $props);
        $ordered = array_map(function($p) use($parts){ return $parts[$p]; }, $props);
        return implode(', ', array_filter($ordered));
    }

    public function isGeocoded() {
        return $this->lat && $this->lon;
    }

    public function compareByCoords(self $address, $precision = 4)
    {
        // rounding leads to mistakes due to highly random numbers after 5th sign
        // return round($this->getLat(), $precision) === round($address->getLat(), $precision)
        //    && round($this->getLon(), $precision) === round($address->getLon(), $precision);
        return intval($this->getLat() * pow(10, $precision)) === intval($address->getLat() * pow(10, $precision))
            && intval($this->getLon() * pow(10, $precision)) === intval($address->getLon() * pow(10, $precision));
    }

    public function merge(self $address)
    {
        foreach (array_keys($this->toArray()) as $prop) {
            if (is_null($this->{$prop}) && !is_null($address->{$prop})) {
                $this->{$prop} = $address->{$prop};
            }
        }
    }

    function __get($name)
    {
        $method = 'get' . studly_case($name);
        if (method_exists($this, $method)) {
            return $this->{$method};
        }

        throw new BadMethodCallException;
    }


    function __set($name, $value)
    {
        if (in_array($name, array_keys($this->toArray()))) {
            $this->{$name} = $this->typeCast($value, $name);
        } else {
            throw new BadMethodCallException;
        }
    }


    function __toString(): string
    {
        return $this->getLocalAddress();
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'postcode' => $this->getPostcode(),
            'apartment' => $this->getApartment(),
            'street' => $this->getStreet(),
            'building' => $this->getBuilding(),
            'district' => $this->getDistrict(),
            'city' => $this->getCity(),
            'state' => $this->getstate(),
            'country' => $this->getCountry(),
            'country_code' => $this->getCountryCode(),
            'lat' => $this->getLat(),
            'lon' => $this->getLon(),
        ];
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int $options
     * @return string
     */
    public function toJson($options = 0): string
    {
        return json_encode($this->toArray());
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        return $this->toArray();
    }

    function __invoke(...$arguments)
    {
        return new self(...$arguments);
    }
}