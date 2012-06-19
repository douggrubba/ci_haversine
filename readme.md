# CodeIgniter Haversine Model

_CodeIgniter Model implementing the haversine formula, giving great-circle distances between two points on a sphere from their longitudes and latitudes._

## Installation
Just drop this model into your `application/models` folder (download or git)

## Usage

#### Load the Model
`$this->load->model('haversine');`

#### Define the Table Name
`$this->haversine->table_name = 'locations';`

#### Run the "Spatial" query
`$locations = $this->haversine->closest(36, -80); //lat, lng`

### Extra Params

#### Maximum Distance
`$locations = $this->haversine->closest(36, -80, 25); //25 Miles`

#### Maximum Locations
`$locations = $this->haversine->closest(36, -80, 25, 10); //10 Locations`

#### Define the Units of Measurement
`$locations = $this->haversine->closest(36, -80, 25, 10, 'miles'); //miles or kilometers`

#### Define what fields you would like back
`$locations = $this->haversine->closest(36, -80, 25, 10, 'miles', array('id, name')); //false for * or single dim array`

## TODO
* More units of measurement (feet, meters)
* Support joins (ie join company meta to a store locations table)
* Change direction of result
* Put `units` param right after longitude
* Refractor into a more general GIS model?