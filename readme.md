# CodeIgniter Haversine Model

_CodeIgniter Model implementing the haversine formula, giving great-circle distances between two points on a sphere from their longitudes and latitudes._

## Installation
Just drop this model into your `application/models` folder (download or git)

## Usage

__Load the Model__
`$this->load->model('haversine');`

__Define the Table Name__
`$this->haversine->table_name = 'locations';`

__Run the "Spatial" query__
`$locaitons = $this->haversine->closest(36, -80);`