<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ProductCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Product::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/product');
        CRUD::setEntityNameStrings('product', 'products');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // CRUD::setFromDb(); // columns

        CRUD::addColumns([
            [
                'name' => 'name',
                'type' => 'text',
                'label' => 'Name',
            ],
            [
                'name' => 'slug',
                'type' => 'text',
                'label' => 'Slug',
            ],
            [
                'name' => 'brand_id',
                'type' => 'relationship',
                'label' => 'Brand',
            ],
            [
                'name' => 'category_id',
                'type' => 'relationship',
                'label' => 'Category',
            ],
            [
                'name' => 'sub_category_id',
                'type' => 'relationship',
                'label' => 'Sub Category',
            ],
            [
                'name' => 'image_path',
                'type' => 'image',
                'label' => 'Image',
                'height' => '80px',
                'width' => '80px',
            ],
        ]);

        $this->crud->addFilter(
            [
                'type'  => 'text',
                'name'  => 'search_key',
                'label' => 'Search'
            ],
            false,
            function($value) { // if the filter is active
                $this->crud->addClause('where', 'name', 'LIKE', "%$value%");
                // $this->crud->addClause('where', 'description', 'LIKE', "%$value%");
            }
         );

        $this->crud->addFilter([
            'name'  => 'brand_id',
            'type'  => 'select2',
            'label' => 'Brand'
        ], function() {
            return \App\Models\Brand::all()->pluck('name', 'id')->toArray();
        }, function($value) { // if the filter is active
            $this->crud->addClause('where', 'brand_id', $value);
        });

        $this->crud->addFilter([
            'name'  => 'category_id',
            'type'  => 'select2',
            'label' => 'Category'
        ], function() {
            return \App\Models\Category::all()->pluck('name', 'id')->toArray();
        }, function($value) { // if the filter is active
            $this->crud->addClause('where', 'category_id', $value);
        });

        $this->crud->addFilter([
            'name'  => 'sub_category_id',
            'type'  => 'select2',
            'label' => 'Sub Category'
        ], function() {
            return \App\Models\SubCategory::all()->pluck('name', 'id')->toArray();
        }, function($value) { // if the filter is active
            $this->crud->addClause('where', 'sub_category_id', $value);
        });

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ProductRequest::class);

        // CRUD::setFromDb(); // fields

        CRUD::addField([
            'name' => 'name',
            'type' => 'text'
        ]);
        CRUD::addField([
            'name' => 'description',
            'type' => 'textarea'
        ]);
        CRUD::addField([
            'name' => 'slug',
            'type' => 'hidden'
        ]);
        CRUD::addField([
            'name' => 'brand_id',
            'type' => 'relationship'
        ]);
        CRUD::addField([
            'name' => 'category_id',
            'type' => 'relationship'
        ]);
        CRUD::addField([
            'name' => 'sub_category_id',
            'type' => 'relationship'
        ]);
        CRUD::addField([
            'name' => 'price',
            'type' => 'number'
        ]);
        CRUD::addField([
            'name'      => 'image_path',
            'label'     => 'Image',
            'type'      => 'image',
            'upload'    => true,
        ]);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
