<?php
namespace App\Http\Controllers\Admin\Ecommerce;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;
use Storage;
use Maatwebsite\Excel\Facades\Excel;

class ProductsController extends Controller{
    function index(Request $request){
        if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
            //Header Data
            $result = array(
                'page_title' => 'Manage Products',
                'meta_keywords' => '',
                'meta_description' => '',
            );

            //Query For Getting Products
            $query = DB::table('tbl_products')
                         ->select('tbl_products.id', 'tbl_products_featured_images.featured_image', 'name', 'slug', 'sku_code', 'tbl_products.created_date', 'regural_price', 'sale_price', 'quantity', 'tbl_products.status', 'is_approved', 'first_name', 'last_name', 'from_date', 'to_date')
                         ->leftJoin('tbl_products_featured_images', 'tbl_products_featured_images.product_id', '=', 'tbl_products.id')
                         ->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_products.user_id')
                         ->orderBy('tbl_products.id', 'DESC');
            $result['query'] = $query->paginate(10);
            $result['total_records'] = $result['query']->count();

            //Query For Getting Vendors
            $query = DB::table('tbl_products')
                         ->select('tbl_users.id', 'first_name', 'last_name')
                         ->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_products.user_id')
                         ->orderBy('tbl_products.id', 'DESC')
                         ->groupBy('tbl_products.user_id');
            $result['vendors'] = $query->get();

            //call page
            return view('admin.ecommerce.products.manage', $result); 
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }

    function add(Request $request){
        if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
            //Header Data
            $result = array(
                'page_title' => 'Add Products',
                'meta_keywords' => '',
                'meta_description' => '',
            );

            //Query For Getting Brands
            $query = DB::table('tbl_brands_for_products')
                         ->select('id', 'name', 'status')
                         ->where('status', 0)
                         ->orderBy('id', 'DESC');
            $result['brands'] = $query->get();

            //Query For Getting Parent Categories
            $query = DB::table('tbl_parent_categories')
                         ->select('id', 'name', 'status')
                         ->where('status', 0)
                         ->orderBy('id', 'DESC');
            $result['parent_categories'] = $query->get();

            //call page
            return view('admin.ecommerce.products.add', $result); 
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }

    function variation_labels(Request $request){
        if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
            //initializing Generate data variables
            $ajax_response_data = array(
                'ERROR' => 'FALSE',
                'DATA' => '',
            );

            //Query For Getting Variation Labels
            $query = DB::table('tbl_variations_for_products')
                         ->select('id', 'value', 'status')
                         ->where('status', 0)
                         ->orderBy('id', 'DESC');
            $result = $query->get();

            //initializing id
            $id = uniqid();

            //initializing html variable
            $html = '';
            if(!empty($result)){
$html .=    '<div class="row main" data-id="'.$id.'">
                <div class="col-md-4 main1">
                    <h6>Variation Information</h6>
                </div>
                <div class="col-md-5 main1"></div>
                <div class="col-md-3 main1">
                    <h6>Avaliability : </h6>
                    <label class="switch">
                        <input type="hidden" name="status[]" id="'.$id.'" value="1">
                        <input type="checkbox" id="status" data-id="'.$id.'" class="form-control">
                        <span class="slider"></span>
                    </label>
                </div>
                <div class="col-md-12 contain">
                    <select name="variation[]" id="variation" class="form-control select_2 variation_'.$id.'" style="width:100%" data-id="'.$id.'">
                        <option>Select Variant</option>';
            foreach($result as $options){
              $html .= '<option value="'.$options->id.'">'.$options->value.'</option>';
            }
              $html .= '</select>
                    <a href="javascript::void(0);" id="remove_variation" style="color: red"><i class="ft-minus"> Remove</i></a><br><p style="color: red;padding: 1%;margin-top: 2%;margin-bottom: 2%;padding-left: 0%;">Drag and drop pictures below to upload.Multiple images can be uploaded at once.Maximum 5 pictures, size between 650*850 px.</p>
                </div>
                <div class="col-md-12" style="margin-left: 1%; border: 1px solid lightgray; padding: 15px;max-width: 98%;">
                    <div class="image-upload-wrap">
                        <input type="file" id="multi_image" name="product_images[]" multiple data-id="'.$id.'">
                    </div>
                    <div class="file-upload-content">
                        <div class="col-md-12" id="preview_images_'.$id.'">
                            <ul id="sortable" class="sortable_dragable_image_ul preview_images_'.$id.'">
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 items1" style="margin-left:1%;max-width: 98%;">
                    <br><div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-5">
                                    <label>Product SKU</label><label class="label-control" style="color:red">*</label> 
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" id="sku" name="sku[]" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-5">
                                    <label>Quantity</label><label class="label-control" style="color:red">*</label> 
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" id="quantity" name="quantity[]" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-5">
                                    <label>Price</label><label class="label-control" style="color:red">*</label> 
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" id="price" name="price[]" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-5">
                                    <label>Special Price</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" id="sale_price" name="sale_price[]" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-5">
                                    <label>Promotion Start Date</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" id="'.uniqid().'" name="from[]" class="form-control advertise_datepicker" style="width: 100%;height: 38px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-5">
                                    <label>Promotion End Date</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" id="'.uniqid().'" name="to[]" class="form-control advertise_datepicker" style="width: 100%;height: 38px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>';
                $ajax_response_data = array(
                    'ERROR' => 'FALSE',
                    'DATA' => $html,
                );
                echo json_encode($ajax_response_data);
            }else{
                $ajax_response_data = array(
                    'ERROR' => 'TRUE',
                    'DATA' => '',
                );
                echo json_encode($ajax_response_data);
            }
            die;
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }

    function get_child_categories(Request $request, $id){
        if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
            $ajax_response_data = array(
                'ERROR' => 'FALSE',
                'DATA' => '',
            );

            $query = DB::table('tbl_child_categories')
                         ->select('id', 'name')
                         ->where('parent_id', $id)
                         ->where('status', 0);
            $result = $query->get();

            $html = '';
            if(!empty($result->count() > 0)){
                foreach($result as $row){
                    $html .= '<option value='.$row->id.'>'.$row->name.'</option>';
                }    

                $ajax_response_data = array(
                    'ERROR' => 'FALSE',
                    'DATA' => '<option>No child cateogry selected</option>'.$html,
                );

                echo json_encode($ajax_response_data);
            }else{
                $ajax_response_data = array(
                    'ERROR' => 'TRUE',
                    'DATA' => '',
                );

                echo json_encode($ajax_response_data);
            }
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
        die;
    }

    function get_sub_child_categories(Request $request, $id){
        if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
            $ajax_response_data = array(
                'ERROR' => 'FALSE',
                'DATA' => '',
            );

            $query = DB::table('tbl_sub_child_categories')
                         ->select('id', 'name')
                         ->where('child_id', $id)
                         ->where('status', 0);
            $result = $query->get();

            $html = '';
            if(!empty($result->count() > 0)){
                foreach($result as $row){
                    $html .= '<option value='.$row->id.'>'.$row->name.'</option>';
                }    

                $ajax_response_data = array(
                    'ERROR' => 'FALSE',
                    'DATA' => '<option>No sub child cateogry selected</option>'.$html,
                );

                echo json_encode($ajax_response_data);
            }else{
                $ajax_response_data = array(
                    'ERROR' => 'TRUE',
                    'DATA' => '',
                );

                echo json_encode($ajax_response_data);
            }
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
        die;
    }

    function insert(Request $request){
        if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
            //Get All Inputs
            $images = $request->input('images');
            $images_url = $request->input('url');
            $variation = $request->input('variation');
            $status = $request->input('status');
            $sku = $request->input('sku');
            $quantity = $request->input('quantity');
            $price = $request->input('price');
            $sale_price = $request->input('sale_price');
            $from = $request->input('from');
            $to = $request->input('to');
            
            //Inputs Validation
            $input_validations = $request->validate([
                'name' => 'required',
                'parent_category' => 'required|numeric',
                'child_category' => 'required|numeric',
                'sub_child_category' => 'required|numeric',
                'brand' => 'required|numeric',
                'high_light' => 'required',
                'details' => 'required',
                'warranty_type' => 'required',
                'weight' => 'required',
                'length' => 'nullable|numeric',
                'width' => 'nullable|numeric',
                'height' => 'nullable|numeric',
                'variation.*' => 'required|numeric',
                'product_images.*' => 'required|max:5120',
                'status.*' => 'required',
                'sku.*' => 'required',
                'quantity.*' => 'required|numeric',
                'price.*' => 'required|numeric',
                'sale_price.*' => 'nullable|numeric',
                'from.*' => 'nullable',
                'to.*' => 'nullable',
                'video_url' => 'nullable',
                'meta_keywords' => 'nullable',
                'meta_description' => 'nullable',
                'images.*' => 'required',
                'url.*' => 'required',
            ]);
            
            $count = 0;
            foreach($variation as $row){
                if($request->input('sale_price')[$count] >= $request->input('price')[$count]){
                    //Flash Error Msg
                    $request->session()->flash('alert-danger', 'Special price must be less than the price.');

                    //Redirect
                    return redirect()->back()->withInput($request->all());
                }else{
                    if(!empty($request->input('from')[$count] && $request->input('to')[$count])){
                        $from_date = date('Y-m-d', strtotime($request->input('from')[$count]));
                        $to_date = date('Y-m-d', strtotime($request->input('to')[$count]));
                    }else{
                        $from_date = NULL;
                        $to_date = NULL;
                    }

                    //Set Field data according to table columns
                    $data = array(
                        'ip_address' => $request->ip(),
                        'user_id' => $request->session()->get('id'),
                        'name' => $request->input('name'),
                        'slug' => strtolower(str_replace(' ', '-', $request->input('name'))),
                        'high_light' => $request->input('high_light'),
                        'description' => $request->input('details'),
                        'warranty_type' => $request->input('warranty_type'),
                        'what_in_the_box' => $request->input('what_in_the_box'),
                        'weight' => $request->input('weight'),
                        'length' => $request->input('length'),
                        'width' => $request->input('width'),
                        'height' => $request->input('height'),
                        'variation_id' => $row,
                        'sku_code' => $request->input('sku')[$count],
                        'regural_price' => $request->input('price')[$count],
                        'sale_price' => $request->input('sale_price')[$count],
                        'quantity' => $request->input('quantity')[$count],
                        'from_date' => $from_date,
                        'to_date' => $to_date,
                        'status' => $request->input('status')[$count],
                        'video_url' => $request->input('video_url'),
                        'meta_keywords' => $request->input('meta_keywords'),
                        'meta_description' => $request->input('meta_description'),
                        'created_date' => date('Y-m-d'),
                        'created_time' => date('h:i:s'),
                    );

                    //Query For Inserting Data
                    $product_id = DB::table('tbl_products')
                                      ->insertGetId($data);    
                    $count++;

                    foreach($images_url[$row] as $url){
                        //Upload Product Image
                        $image = uniqid().'.jpeg';
                        $image_path = file_put_contents($_SERVER["DOCUMENT_ROOT"].'/public/assets/admin/images/ecommerce/products/'.$image, file_get_contents($url));

                        //Set Field data according to table columns
                        $data = array(
                            'ip_address' => $request->ip(),
                            'user_id' => $request->session()->get('id'),
                            'product_id' => $product_id,
                            'image' => $image,
                        ); 
                        
                        //Query For Inserting Data
                        $image_id = DB::table('tbl_products_images')
                                        ->insertGetId($data);

                        $pro_images[] = $image; 
                    }
                    
                    //Set Field data according to table columns
                    $data = array(
                        'featured_image' => $pro_images[0],
                        'product_id' => $product_id,
                    );

                    //Query For Inserting Data
                    $brand_id = DB::table('tbl_products_featured_images')
                                    ->insertGetId($data);

                    //Set Field data according to table columns
                    $data = array(
                        'ip_address' => $request->ip(),
                        'user_id' => $request->session()->get('id'),
                        'product_id' => $product_id,
                        'brand_id' => $request->input('brand'),
                    );

                    //Query For Inserting Data
                    $brand_id = DB::table('tbl_product_brands')
                                    ->insertGetId($data);

                    //Set Field data according to table columns
                    $data = array(
                        'ip_address' => $request->ip(),
                        'user_id' => $request->session()->get('id'),
                        'product_id' => $product_id,
                        'parent_id' => $request->input('parent_category'),
                        'child_id' => $request->input('child_category'),
                        'sub_child_id' => $request->input('sub_child_category'),
                    );

                    //Query For Inserting Data
                    $category_id = DB::table('tbl_product_categories')
                                       ->insertGetId($data);
                }
            }

            if(!empty($category_id)){
                //Flash Error Msg
                $request->session()->flash('alert-success', 'Product has been added successfully');
            }else{
                $p_id = DB::table('tbl_products')
                             ->where('id', $product_id)
                             ->delete();

                $b_id = DB::table('tbl_product_brands')
                             ->where('product_id', $product_id)
                             ->delete();

                $c_id = DB::table('tbl_product_categories')
                             ->where('product_id', $product_id)
                             ->delete();

                $i_id = DB::table('tbl_products_images')
                             ->where('product_id', $product_id)
                             ->delete();
                             
                //Flash Erro Msg
                $request->session()->flash('alert-danger', 'Something went wrong !!');
            }

            //Redirect
            return redirect()->back();
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }

    function ajax_update_status(Request $request, $id, $status){
        if(!empty($request->session()->has('id') && $request->session()->get('role') == 0 && $id)){
            if($status == 0){
                $status = 1;
            }elseif($status == 1){
                $status = 0;
            }

            $query = DB::table('tbl_products')
                         ->where('id', $id)
                         ->update(array('status' => $status));

            if(!empty($query == 1)){
                //Flash Erro Msg
                $request->session()->flash('alert-success', 'Status has been updated successfully');
            }else{
                //Flash Erro Msg
                $request->session()->flash('alert-danger', 'Something went wrong !!');
            }

            //Redirect
            return redirect()->back();
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }

    function ajax_update_cost_price(Request $request, $id){
        if(!empty($request->session()->has('id') && $request->session()->get('role') == 0 && $id)){
            $query = DB::table('tbl_products')
                         ->select('sale_price')
                         ->where('id', $id);
            $sale_price = $query->first();

            if($request->input('cost_price') <= $sale_price->sale_price){
                //Flash Error Msg
                $request->session()->flash('alert-danger', 'Retail price must be greater than the Sale price.');
            }else{
                //Set Field data according to table columns
                $data = array(
                    'regural_price' => $request->input('cost_price'),
                );
                
                //Query For Updating Data
                $query = DB::table('tbl_products')
                         ->where('id', $id)
                         ->update($data);

                if(!empty($query == 1)){
                    //Flash Erro Msg
                    $request->session()->flash('alert-success', 'Retail Price has been updated successfully');
                }else{
                    //Flash Erro Msg
                    $request->session()->flash('alert-danger', 'Something went wrong !!');
                }
            }

            //Redirect
            return redirect()->back();
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }

    function ajax_update_sale_price(Request $request, $id){
        if(!empty($request->session()->has('id') && $request->session()->get('role') == 0 && $id)){
             $query = DB::table('tbl_products')
                         ->select('regural_price')
                         ->where('id', $id);
            $cost_price = $query->first();
            
            if($request->input('sale_price') >= $cost_price->regural_price){
                //Flash Error Msg
                $request->session()->flash('alert-danger', 'Sale price must be less than the Retail price.');
            }else{
                //Set Field data according to table columns
                $data = array(
                    'sale_price' => $request->input('sale_price'), 
                    'from_date' => date('Y-m-d', strtotime($request->input('from_date'))), 
                    'to_date' => date('Y-m-d', strtotime($request->input('to_date'))),
                );
                
                //Query For Updating Data
                $query = DB::table('tbl_products')
                             ->where('id', $id)
                             ->update($data);

                if(!empty($query == 1)){
                    //Flash Erro Msg
                    $request->session()->flash('alert-success', 'Sale Price has been updated successfully');
                }else{
                    //Flash Erro Msg
                    $request->session()->flash('alert-danger', 'Something went wrong !!');
                }
            }

            //Redirect
            return redirect()->back();
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }

    function ajax_update_quantity(Request $request, $id){
        if(!empty($request->session()->has('id') && $request->session()->get('role') == 0 && $id)){
            $query = DB::table('tbl_products')
                         ->where('id', $id)
                         ->update(array('quantity' => $request->input('quantity')));

            if(!empty($query == 1)){
                //Flash Erro Msg
                $request->session()->flash('alert-success', 'Quantity has been updated successfully');
            }else{
                //Flash Erro Msg
                $request->session()->flash('alert-danger', 'Something went wrong !!');
            }

            //Redirect
            return redirect()->back();
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }

    function edit(Request $request, $id){
        if(!empty($request->session()->has('id') && $request->session()->get('role') == 0 && $id)){
            //Header Data
            $result = array(
                'page_title' => 'Edit Product',
                'meta_keywords' => '',
                'meta_description' => '',
            );

            //Query For Getting this Product details
            $query = DB::table('tbl_products')
                         ->select('*')
                         ->where('id', $id);
            $result['query_product'] = $query->first();

            //Query For Getting brand of this Product
            $query = DB::table('tbl_product_brands')
                         ->select('tbl_brands_for_products.id', 'tbl_brands_for_products.name')
                         ->leftJoin('tbl_brands_for_products', 'tbl_brands_for_products.id', '=', 'tbl_product_brands.brand_id')
                         ->where('tbl_product_brands.product_id', $id);
            $result['query_brand'] = $query->first();

            //Query For Getting Categories of this Product
            $query = DB::table('tbl_product_categories')
                         ->select('tbl_parent_categories.id as p_id', 'tbl_parent_categories.name as p_name', 'tbl_child_categories.id as c_id', 'tbl_child_categories.name as c_name', 'tbl_sub_child_categories.id as s_c_id', 'tbl_sub_child_categories.name as s_c_name')
                         ->leftJoin('tbl_parent_categories', 'tbl_parent_categories.id', '=', 'tbl_product_categories.parent_id')
                         ->leftJoin('tbl_child_categories', 'tbl_child_categories.id', '=', 'tbl_product_categories.child_id')
                         ->leftJoin('tbl_sub_child_categories', 'tbl_sub_child_categories.id', '=', 'tbl_product_categories.sub_child_id')
                         ->where('tbl_product_categories.product_id', $id);
            $result['query_categories'] = $query->first();

            //Query For Getting Images of this Product
            $query = DB::table('tbl_products_images')
                         ->select('*')
                         ->where('product_id', $id);
            $result['query_images'] = $query->get();

            //Query For Getting Brands
            $query = DB::table('tbl_brands_for_products')
                         ->select('id', 'name', 'status')
                         ->where('status', 0)
                         ->orderBy('id', 'DESC');
            $result['brands'] = $query->get();

            //Query For Getting Parent Categories
            $query = DB::table('tbl_parent_categories')
                         ->select('id', 'name')
                         ->where('status', 0)
                         ->orderBy('id', 'DESC');
            $result['parent_categories'] = $query->get();

            //Query For Getting Child Categories
            $query = DB::table('tbl_child_categories')
                         ->select('id', 'name')
                         ->where('parent_id', $result['query_categories']->p_id)
                         ->where('status', 0)
                         ->orderBy('id', 'DESC');
            $result['child_categories'] = $query->get();

            //Query For Getting Sub Child Categories
            $query = DB::table('tbl_sub_child_categories')
                         ->select('id', 'name')
                         ->where('child_id', $result['query_categories']->c_id)
                         ->where('status', 0)
                         ->orderBy('id', 'DESC');
            $result['sub_child_categories'] = $query->get();

            //Query For Getting Variations
            $query = DB::table('tbl_variations_for_products')
                         ->select('id', 'value', 'status')
                         ->where('status', 0)
                         ->orderBy('id', 'DESC');
            $result['variations'] = $query->get();
            
            if(!empty($result['query_product'])){
                //call page
                return view('admin.ecommerce.products.edit', $result); 
            }else{
                print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
            }
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }

    function delete_images(Request $request, $id){
        if(!empty($request->session()->has('id') && $request->session()->get('role') == 0 && $id)){
            //initializing Generate data variables
            $ajax_response_data = array(
                'ERROR' => 'FALSE',
                'DATA' => '',
            );

            $image = DB::table('tbl_products_images')
                             ->select('image')
                             ->where('id', $id);
            $result = $image->first();
            
            File::delete(public_path().'/assets/admin/images/ecommerce/products/'.$result->image);

            //Query For Deleting Image 
            $query = DB::table('tbl_products_images')
                         ->where('id', $id)
                         ->delete();

            //check either image is deleted or not
            if(!empty($query)){
                $ajax_response_data = array(
                    'ERROR' => 'FALSE',
                    'DATA' => 'Image has been deleted successfully',
                );
                echo json_encode($ajax_response_data);
            }else{
                $ajax_response_data = array(
                    'ERROR' => 'TRUE',
                    'DATA' => "Something wen't wrong",
                );
                echo json_encode($ajax_response_data); 
            }
            die;
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }

    function update(Request $request, $id){
        if(!empty($request->session()->has('id') && $request->session()->get('role') == 0 && $id)){
            //Get All Inputs
            $images = $request->input('images');
            $images_url = $request->input('url');

            //Inputs Validation
            $input_validations = $request->validate([
                'name' => 'required',
                'parent_category' => 'required|numeric',
                'child_category' => 'required|numeric',
                'sub_child_category' => 'required|numeric',
                'brand' => 'required|numeric',
                'high_light' => 'required',
                'details' => 'required',
                'warranty_type' => 'required',
                'weight' => 'required',
                'length' => 'nullable|numeric',
                'width' => 'nullable|numeric',
                'height' => 'nullable|numeric',
                'variation.*' => 'required|numeric',
                'product_images.*' => 'required|max:5120',
                'status' => 'required',
                'sku' => 'required',
                'quantity' => 'required|numeric',
                'price' => 'required|numeric',
                'sale_price' => 'nullable|numeric',
                'from' => 'nullable',
                'to' => 'nullable',
                'video_url' => 'nullable',
                'meta_keywords' => 'nullable',
                'meta_description' => 'nullable',
                'images.*' => 'required',
                'url.*' => 'required',
            ]);
            
            if(!empty($request->input('variation')[0])){
                if($request->input('sale_price') >= $request->input('price')){
                    //Flash Error Msg
                    $request->session()->flash('alert-danger', 'Special price must be less than the price.');

                    //Redirect
                    return redirect()->back()->withInput($request->all());
                }else{
                    if(!empty($request->input('from') && $request->input('to'))){
                        $from_date = date('Y-m-d', strtotime($request->input('from')));
                        $to_date = date('Y-m-d', strtotime($request->input('to')));
                    }else{
                        $from_date = NULL;
                        $to_date = NULL;
                    } 

                    //Set Field data according to table columns
                    $data = array(
                        'ip_address' => $request->ip(),
                        'user_id' => $request->session()->get('id'),
                        'name' => $request->input('name'),
                        'slug' => strtolower(str_replace(' ', '-', $request->input('name'))),
                        'high_light' => $request->input('high_light'),
                        'description' => $request->input('details'),
                        'warranty_type' => $request->input('warranty_type'),
                        'what_in_the_box' => $request->input('what_in_the_box'),
                        'weight' => $request->input('weight'),
                        'length' => $request->input('length'),
                        'width' => $request->input('width'),
                        'height' => $request->input('height'),
                        'variation_id' => $request->input('variation')[0],
                        'sku_code' => $request->input('sku'),
                        'regural_price' => $request->input('price'),
                        'sale_price' => $request->input('sale_price'),
                        'quantity' => $request->input('quantity'),
                        'from_date' => $from_date,
                        'to_date' => $to_date,
                        'status' => $request->input('status'),
                        'video_url' => $request->input('video_url'),
                        'meta_keywords' => $request->input('meta_keywords'),
                        'meta_description' => $request->input('meta_description'),
                        'created_date' => date('Y-m-d'),
                        'created_time' => date('h:i:s'),
                    );

                    //Query For Updating Data
                    $product_id = DB::table('tbl_products')
                                 ->where('id', $id)
                                 ->update($data);

                    //Query For Deleting Previous Images
                    $query = DB::table('tbl_products_images')
                                 ->where('product_id', $id)
                                 ->delete();

                    $count = 0;
                    foreach($images_url[$request->input('variation')[0]] as $url){
                        if(!empty(file_exists(public_path().'public/assets/admin/images/ecommerce/products/'.$images[$request->input('variation')[0]][$count]))){
                            $image = $images[$request->input('variation')[0]][$count];
                        }else{
                            //Upload Product Image
                            $image = uniqid().'.jpeg';
                            $image_path = file_put_contents($_SERVER["DOCUMENT_ROOT"].'/public/assets/admin/images/ecommerce/products/'.$image, file_get_contents($url));
                        }

                        //Set Field data according to table columns
                        $data = array(
                            'ip_address' => $request->ip(),
                            'user_id' => $request->session()->get('id'),
                            'product_id' => $id,
                            'image' => $image,
                        ); 
                        
                        //Query For Inserting Data
                        $image_id = DB::table('tbl_products_images')
                                        ->insertGetId($data);

                        $pro_images[] = $image;
                        $count++;
                    }

                    //Set Field data according to table columns
                    $data = array(
                        'ip_address' => $request->ip(),
                        'user_id' => $request->session()->get('id'),
                        'featured_image' => $pro_images[0],
                        'product_id' => $id,
                    );

                    //Query For Inserting Data
                    $brand_id = DB::table('tbl_products_featured_images')
                                    ->where('product_id', $id)
                                    ->update($data);

                    //Set Field data according to table columns
                    $data = array(
                        'ip_address' => $request->ip(),
                        'user_id' => $request->session()->get('id'),
                        'brand_id' => $request->input('brand'),
                    );

                    //Query For Updating Data
                    $brand_id = DB::table('tbl_product_brands')
                                    ->where('product_id', $id)
                                    ->update($data);

                    //Set Field data according to table columns
                    $data = array(
                        'ip_address' => $request->ip(),
                        'user_id' => $request->session()->get('id'),
                        'parent_id' => $request->input('parent_category'),
                        'child_id' => $request->input('child_category'),
                        'sub_child_id' => $request->input('sub_child_category'),
                    );

                    //Query For Updating Data
                    $category_id = DB::table('tbl_product_categories')
                                       ->where('product_id', $id)
                                       ->update($data);
                    
                    if(!empty($category_id == 0)){
                        //Flash Erro Msg
                        $request->session()->flash('alert-success', 'Product has been updated successfully');
                    }else{
                        //Flash Erro Msg
                        $request->session()->flash('alert-danger', 'Something went wrong !!');
                    }
                }
            }else{
                //Flash Erro Msg
                $request->session()->flash('alert-danger', 'Variation is required for adding products.');
            }

            //Redirect
            return redirect()->back()->withInput($request->all());
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }

    function delete(Request $request, $id){
        if(!empty($request->session()->has('id') && $request->session()->get('role') == 0 && $id)){
            //Query For Deleting details of this product
            $p_id = DB::table('tbl_products')
                         ->where('id', $id)
                         ->delete();

            //Query for Deleting brand of this product
            $b_id = DB::table('tbl_product_brands')
                         ->where('product_id', $id)
                         ->delete();

            //Query for Deleting categories of this product
            $c_id = DB::table('tbl_product_categories')
                         ->where('product_id', $id)
                         ->delete();

            //Query for Deleting images of this product
            $i_id = DB::table('tbl_products_images')
                         ->where('product_id', $id)
                         ->delete();
            
            if(!empty($i_id && $b_id && $c_id && $i_id)){
                //Flash Erro Msg
                $request->session()->flash('alert-success', 'Product has been deleted successfully');
            }else{
                //Flash Erro Msg
                $request->session()->flash('alert-danger', 'Something went wrong !!');
            }

            //Redirect
            return redirect()->back();
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }             
    }

    function copy_product(Request $request, $id){
        if(!empty($request->session()->has('id') && $request->session()->get('role') == 0 && $id)){
            //Header Data
            $result = array(
                'page_title' => 'Copy Product',
                'meta_keywords' => '',
                'meta_description' => '',
            );

            //Query For Getting this Product details
            $query = DB::table('tbl_products')
                         ->select('*')
                         ->where('id', $id);
            $result['query_product'] = $query->first();

            //Query For Getting brand of this Product
            $query = DB::table('tbl_product_brands')
                         ->select('tbl_brands_for_products.id', 'tbl_brands_for_products.name')
                         ->leftJoin('tbl_brands_for_products', 'tbl_brands_for_products.id', '=', 'tbl_product_brands.brand_id')
                         ->where('tbl_product_brands.product_id', $id);
            $result['query_brand'] = $query->first();

            //Query For Getting Categories of this Product
            $query = DB::table('tbl_product_categories')
                         ->select('tbl_parent_categories.id as p_id', 'tbl_parent_categories.name as p_name', 'tbl_child_categories.id as c_id', 'tbl_child_categories.name as c_name', 'tbl_sub_child_categories.id as s_c_id', 'tbl_sub_child_categories.name as s_c_name')
                         ->leftJoin('tbl_parent_categories', 'tbl_parent_categories.id', '=', 'tbl_product_categories.parent_id')
                         ->leftJoin('tbl_child_categories', 'tbl_child_categories.id', '=', 'tbl_product_categories.child_id')
                         ->leftJoin('tbl_sub_child_categories', 'tbl_sub_child_categories.id', '=', 'tbl_product_categories.sub_child_id')
                         ->where('tbl_product_categories.product_id', $id);
            $result['query_categories'] = $query->first();

            //Query For Getting Images of this Product
            $query = DB::table('tbl_products_images')
                         ->select('*')
                         ->where('product_id', $id);
            $result['query_images'] = $query->get();

            //Query For Getting Brands
            $query = DB::table('tbl_brands_for_products')
                         ->select('id', 'name', 'status')
                         ->where('status', 0)
                         ->orderBy('id', 'DESC');
            $result['brands'] = $query->get();

            //Query For Getting Parent Categories
            $query = DB::table('tbl_parent_categories')
                         ->select('id', 'name')
                         ->where('status', 0)
                         ->orderBy('id', 'DESC');
            $result['parent_categories'] = $query->get();

            //Query For Getting Child Categories
            $query = DB::table('tbl_child_categories')
                         ->select('id', 'name')
                         ->where('parent_id', $result['query_categories']->p_id)
                         ->where('status', 0)
                         ->orderBy('id', 'DESC');
            $result['child_categories'] = $query->get();

            //Query For Getting Sub Child Categories
            $query = DB::table('tbl_sub_child_categories')
                         ->select('id', 'name')
                         ->where('child_id', $result['query_categories']->c_id)
                         ->where('status', 0)
                         ->orderBy('id', 'DESC');
            $result['sub_child_categories'] = $query->get();

            //Query For Getting Variations
            $query = DB::table('tbl_variations_for_products')
                         ->select('id', 'value', 'status')
                         ->where('status', 0)
                         ->orderBy('id', 'DESC');
            $result['variations'] = $query->get();
            
            if(!empty($result['query_product'])){
                //call page
                return view('admin.ecommerce.products.copy', $result); 
            }else{
                print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
            }
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }      
    }

    function insert_copy_product(Request $request){
        if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
            //Get All Inputs
            $images = $request->input('images');
            $images_url = $request->input('url');

            //Inputs Validation
            $input_validations = $request->validate([
                'name' => 'required',
                'parent_category' => 'required',
                'child_category' => 'required',
                'sub_child_category' => 'required',
                'brand' => 'required',
                'high_light' => 'required',
                'details' => 'required',
                'warranty_type' => 'required',
                'weight' => 'required',
                'length' => 'nullable|numeric',
                'width' => 'nullable|numeric',
                'height' => 'nullable|numeric',
                'variation' => 'required|numeric',
                'product_images.*' => 'required|max:5120',
                'status' => 'required',
                'sku' => 'required',
                'quantity' => 'required|numeric',
                'price' => 'required|numeric',
                'sale_price' => 'nullable|numeric',
                'from' => 'nullable',
                'to' => 'nullable',
                'video_url' => 'nullable',
                'meta_keywords' => 'nullable',
                'meta_description' => 'nullable',
                'images.*' => 'required',
                'url.*' => 'required',
            ]);

            if(!empty($request->input('variation'))){
                if($request->input('sale_price') >= $request->input('price')){
                    //Flash Error Msg
                    $request->session()->flash('alert-danger', 'Special price must be less than the price.');

                    //Redirect
                    return redirect()->back()->withInput($request->all());
                }else{
                    if(!empty($request->input('from') && $request->input('to'))){
                        $from_date = date('Y-m-d', strtotime($request->input('from')));
                        $to_date = date('Y-m-d', strtotime($request->input('to')));
                    }else{
                        $from_date = NULL;
                        $to_date = NULL;
                    } 

                    //Set Field data according to table columns
                    $data = array(
                        'ip_address' => $request->ip(),
                        'user_id' => $request->session()->get('id'),
                        'name' => $request->input('name'),
                        'slug' => strtolower(str_replace(' ', '-', $request->input('name'))),
                        'high_light' => $request->input('high_light'),
                        'description' => $request->input('details'),
                        'warranty_type' => $request->input('warranty_type'),
                        'what_in_the_box' => $request->input('what_in_the_box'),
                        'weight' => $request->input('weight'),
                        'length' => $request->input('length'),
                        'width' => $request->input('width'),
                        'height' => $request->input('height'),
                        'variation_id' => $request->input('variation'),
                        'sku_code' => $request->input('sku'),
                        'regural_price' => $request->input('price'),
                        'sale_price' => $request->input('sale_price'),
                        'quantity' => $request->input('quantity'),
                        'from_date' => $from_date,
                        'to_date' => $to_date,
                        'status' => $request->input('status'),
                        'video_url' => $request->input('video_url'),
                        'meta_keywords' => $request->input('meta_keywords'),
                        'meta_description' => $request->input('meta_description'),
                        'created_date' => date('Y-m-d'),
                        'created_time' => date('h:i:s'),
                    );

                    //Query For Updating Data
                    $product_id = DB::table('tbl_products')
                                 ->insertGetId($data);

                    foreach($images_url[$request->input('variation')] as $url){
                        //Upload Product Image
                        $image = uniqid().'.jpeg';
                        $image_path = file_put_contents($_SERVER["DOCUMENT_ROOT"].'/public/assets/admin/images/ecommerce/products/'.$image, file_get_contents($url));

                        //Set Field data according to table columns
                        $data = array(
                            'ip_address' => $request->ip(),
                            'user_id' => $request->session()->get('id'),
                            'product_id' => $product_id,
                            'image' => $image,
                        ); 
                        
                        //Query For Inserting Data
                        $image_id = DB::table('tbl_products_images')
                                        ->insertGetId($data);

                        $pro_images[] = $image; 
                    }

                    //Set Field data according to table columns
                    $data = array(
                        'featured_image' => $pro_images[0],
                        'product_id' => $product_id,
                    );

                    //Query For Inserting Data
                    $brand_id = DB::table('tbl_products_featured_images')
                                    ->insertGetId($data);

                    //Set Field data according to table columns
                    $data = array(
                        'ip_address' => $request->ip(),
                        'user_id' => $request->session()->get('id'),
                        'brand_id' => $request->input('brand'),
                        'product_id' => $product_id,
                    );

                    //Query For Updating Data
                    $brand_id = DB::table('tbl_product_brands')
                                    ->insertGetId($data);

                    //Set Field data according to table columns
                    $data = array(
                        'ip_address' => $request->ip(),
                        'user_id' => $request->session()->get('id'),
                        'parent_id' => $request->input('parent_category'),
                        'child_id' => $request->input('child_category'),
                        'sub_child_id' => $request->input('sub_child_category'),
                        'product_id' => $product_id
                    );

                    //Query For Updating Data
                    $category_id = DB::table('tbl_product_categories')
                                       ->insertGetId($data);
                    
                    if(!empty($category_id)){
                        //Flash Erro Msg
                        $request->session()->flash('alert-success', 'Product has been added successfully');
                    }else{
                        $p_id = DB::table('tbl_products')
                                     ->where('id', $product_id)
                                     ->delete();

                        $b_id = DB::table('tbl_product_brands')
                                     ->where('product_id', $product_id)
                                     ->delete();

                        $c_id = DB::table('tbl_product_categories')
                                     ->where('product_id', $product_id)
                                     ->delete();

                        $i_id = DB::table('tbl_products_images')
                                     ->where('product_id', $product_id)
                                     ->delete();
                                     
                        //Flash Erro Msg
                        $request->session()->flash('alert-danger', 'Something went wrong !!');
                    }
                }
            }else{
                //Flash Erro Msg
                $request->session()->flash('alert-danger', 'Variation is required for adding products.');
            }

            //Redirect
            return redirect()->back()->withInput($request->all());
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }

    function search(Request $request){
        if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
            //Header Data
            $result = array(
                'page_title' => 'Search Records',
                'meta_keywords' => '',
                'meta_description' => '',
            ); 

            $query = DB::table('tbl_products')
                         ->select('tbl_products.id', 'tbl_products_featured_images.featured_image', 'name', 'slug', 'sku_code', 'tbl_products.created_date', 'regural_price', 'sale_price', 'quantity', 'tbl_products.status', 'is_approved', 'first_name', 'last_name', 'from_date', 'to_date')
                         ->leftJoin('tbl_products_featured_images', 'tbl_products_featured_images.product_id', '=', 'tbl_products.id')
                         ->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_products.user_id');
                         if(!empty($request->input('name'))){
                   $query->where('name', 'LIKE', '%'.$request->input('name').'%');
                         }
                         if(!empty($request->input('sku'))){
                   $query->where('sku_code', 'LIKE', '%'.$request->input('sku').'%');
                         }
                   $query->orderBy('tbl_products.id', 'DESC');
            $result['query'] = $query->paginate(10);
            $result['total_records'] = $result['query']->count();

            //call page
            return view('admin.ecommerce.products.manage', $result); 
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }

    function export(Request $request){
        if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
            //Query For Getting Product
            $query = DB::table('tbl_products')
                     ->select('tbl_products_featured_images.featured_image', 'tbl_products.id', 'tbl_products.name as product_name', 'tbl_products.slug as product_slug', 'tbl_products.sKU_code', 'tbl_products.high_light', 'tbl_products.description', 'tbl_products.warranty_type', 'tbl_products.what_in_the_box', 'tbl_products.weight', 'tbl_products.length', 'tbl_products.width', 'tbl_products.height', 'tbl_products.regural_price', 'tbl_products.sale_price', 'tbl_products.from_date', 'tbl_products.to_date', 'tbl_products.sku_code', 'tbl_products.quantity', 'tbl_products.video_url', 'tbl_products.meta_keywords', 'tbl_products.meta_description', 'tbl_brands_for_products.name as brand_name', 'tbl_users.first_name', 'tbl_users.last_name', 'tbl_parent_categories.name as parent_category', 'tbl_child_categories.name as child_category', 'tbl_sub_child_categories.name as sub_child_category', 'tbl_variations_for_products.value')
                     ->LeftJoin('tbl_products_featured_images', 'tbl_products_featured_images.product_id', '=', 'tbl_products.id')
                     ->LeftJoin('tbl_product_brands', 'tbl_product_brands.product_id', '=', 'tbl_products.id')
                     ->LeftJoin('tbl_brands_for_products', 'tbl_brands_for_products.id', '=', 'tbl_product_brands.brand_id')
                     ->LeftJoin('tbl_product_categories', 'tbl_product_categories.product_id', '=', 'tbl_products.id')
                     ->LeftJoin('tbl_parent_categories', 'tbl_parent_categories.id', '=', 'tbl_product_categories.parent_id')
                     ->LeftJoin('tbl_child_categories', 'tbl_child_categories.id', '=', 'tbl_product_categories.child_id')
                     ->LeftJoin('tbl_sub_child_categories', 'tbl_sub_child_categories.id', '=', 'tbl_product_categories.sub_child_id')
                     ->LeftJoin('tbl_variations_for_products', 'tbl_variations_for_products.id', '=', 'tbl_products.variation_id')
                     ->LeftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_products.user_id');
                     if(!empty($request->input('product_status') != 2)){
               $query->where('tbl_products.status', $request->input('product_status'));
                     }
                     if(!empty($request->input('product_type') != 2)){
               $query->where('tbl_products.is_approved', $request->input('product_type'));
                     }
                     if(!empty($request->input('vendor') != 0)){
               $query->where('tbl_products.user_id', $request->input('vendor'));
                     }
               $query->orderBy('tbl_products.id', 'DESC');
            $products = $query->get();

            //Check If Products are Exist Or Not
            if(!empty($products)){
                foreach($products as $row){
                    //Query For Getting Images Of Specific Products
                    $query = DB::table('tbl_products_images')
                                 ->select('tbl_products_images.image', 'tbl_products.name')
                                 ->LeftJoin('tbl_products', 'tbl_products.id', '=', 'tbl_products_images.product_id')
                                 ->where('tbl_products_images.product_id', $row->id)
                                 ->orderBy('tbl_products_images.product_id', 'DESC');
                    $products_images = $query->get();

                    if(!empty(count($products_images) > 0)){
                        $count = 1;
                        foreach($products_images as $products_image){
                            $product_imagess['product_image_'.$count] = public_path().'/assets/admin/images/ecommerce/products/'.$products_image->image;
                            $count++;
                        }
                    }

                    //Warranty Type
                    if($row->warranty_type == 0){
                        $warranty_type = 'Brand warranty';
                    }elseif($row->warranty_type == 1){
                        $warranty_type = 'International manufacture warranty';
                    }elseif($row->warranty_type == 2){
                        $warranty_type = 'International seller warranty';
                    }elseif($row->warranty_type == 3){
                        $warranty_type = 'International warranty';
                    }elseif($row->warranty_type == 4){
                        $warranty_type = 'Local warranty';
                    }elseif($row->warranty_type == 5){
                        $warranty_type = 'Seller Shop warranty';
                    }elseif($row->warranty_type == 6){
                        $warranty_type = 'Shopker warranty';
                    }elseif($row->warranty_type == 7){
                        $warranty_type = 'No warranty';
                    }

                    //Length
                    if($row->length == ''){
                        $length = NULL;
                    }else{
                        $length = $row->length;
                    }

                    //Width
                    if($row->width == ''){
                        $width = NULL;
                    }else{
                        $width = $row->width;
                    }

                    //Height
                    if($row->height == ''){
                        $height = NULL;
                    }else{
                        $height = $row->height;
                    }

                    //Sale Price
                    if($row->sale_price == ''){
                        $sale_price = NULL;
                    }else{
                        $sale_price = $row->sale_price;
                    }

                    //Promotion Start Date
                    if($row->from_date == ''){
                        $from_date = NULL;
                    }else{
                        $from_date = date('d-m-Y', strtotime($row->from_date));
                    }

                    //Promotion End Date
                    if($row->to_date == ''){
                        $to_date = NULL;
                    }else{
                        $to_date = date('d-m-Y', strtotime($row->to_date));
                    }

                    //Meta Keywords
                    if($row->meta_keywords == ''){
                        $meta_keywords = NULL;
                    }else{
                        $meta_keywords = $row->meta_keywords;
                    }

                    //Meta Description
                    if($row->meta_description == ''){
                        $meta_description = NULL;
                    }else{
                        $meta_description = $row->meta_description;
                    }

                    $product_details = array(
                        'vendor_name' => $row->first_name.' '.$row->last_name,
                        'name' => $row->product_name,
                        'sku_code' => $row->sKU_code,
                        'brand_name' => $row->brand_name,
                        'parent_category' => $row->parent_category,
                        'child_category' => $row->child_category,
                        'sub_child_category' => $row->sub_child_category,
                        'highlight' => $row->high_light,
                        'description' => $row->description,
                        'warranty_type' => $warranty_type,
                        'whats_in_the_box' => $row->what_in_the_box,
                        'weight' => $row->weight,
                        'length' => $row->length,
                        'width' => $row->width,
                        'height' => $row->height,
                        'cost_price' => $row->regural_price,
                        'sale_price' => $sale_price,
                        'promotion_start_date' => $from_date,
                        'promotion_end_date' => $to_date,
                        'quantity' => $row->quantity,
                        'variation' => $row->value,
                        'meta_keywords' => $meta_keywords,
                        'meta_description' => $meta_description,
                        'video' => $row->video_url,
                        'featured_image' => public_path().'/assets/admin/images/ecommerce/products/'.$row->featured_image,
                    );
                    
                    if(empty($product_imagess)){
                        $data[] = $product_details;
                    }elseif(!empty($product_imagess)){
                        $data[] = array_merge($product_details, $product_imagess);
                    }
                }
                
                //Export As Excel File
                $excel_sheet = Excel::create($request->input('name'), function($excel) use ($data){
                    $excel->sheet('Products Details', function($sheet) use ($data){
                        $sheet->fromArray($data);
                    });
                })->download('xlsx');

                //Flash Success Msg
                $request->session()->flash('alert-success', 'Products export successfully.');
            }else{
                //Flash Erro Msg
                $request->session()->flash('alert-danger', 'Products not exist for following request.');
            }

            //Reidrect
            return redirect()->back();
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }

    function import(Request $request){
        if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
            //Getting Import File Content
            $data = Excel::load($request->file('products')->getRealPath());
            $result = $data->toArray();
            
            if(!empty(count($result) > 0)){
                foreach($result as $row){
                    //Query For Getting Vendor Id
                    $query = DB::table('tbl_users')
                                 ->select('tbl_users.id as vendor_id', 'store_name')
                                 ->leftJoin('tbl_store_settings', 'tbl_store_settings.vendor_id', '=', 'tbl_users.id')
                                 ->where(DB::raw("CONCAT(first_name, ' ', last_name)"), $row['vendor_name']);
                    $vendor_details = $query->first();

                    //Query For Getting Brand Id
                    $query = DB::table('tbl_brands_for_products')
                                 ->select('id as brand_id')
                                 ->where('name', 'Like', '%'.$row['brand_name'].'%');
                    $brand_details = $query->first();

                    //Query For Getting Parent Category Id
                    $query = DB::table('tbl_parent_categories')
                                 ->select('id as category_id')
                                 ->where('name', 'Like', '%'.$row['parent_category'].'%');
                    $parent_category = $query->first();

                    //Query For Getting Child Category Id
                    $query = DB::table('tbl_child_categories')
                                 ->select('id as category_id')
                                 ->where('name', 'Like', '%'.$row['child_category'].'%');
                    $child_category = $query->first();

                    //Query For Getting Sub Child Category Id
                    $query = DB::table('tbl_sub_child_categories')
                                 ->select('id as category_id')
                                 ->where('name', 'Like', '%'.$row['sub_child_category'].'%');
                    $sub_child_category = $query->first();

                    //Query For Getting Variation Id
                    $query = DB::table('tbl_variations_for_products')
                                 ->select('id as variation_id')
                                 ->where('value', 'Like', '%'.$row['variation'].'%');
                    $variation_details = $query->first();

                    if($row['warranty_type'] == 'Brand warranty'){
                        $warranty_type = 0;
                    }elseif($row['warranty_type'] == 'International manufacture warranty'){
                        $warranty_type = 1;
                    }elseif($row['warranty_type'] == 'International seller warranty'){
                        $warranty_type = 2;
                    }elseif($row['warranty_type'] == 'International warranty'){
                        $warranty_type = 3;
                    }elseif($row['warranty_type'] == 'Local warranty'){
                        $warranty_type = 4;
                    }elseif($row['warranty_type'] == 'Seller Shop warranty'){
                        $warranty_type = 5;
                    }elseif($row['warranty_type'] == 'Shopker warranty'){
                        $warranty_type = 6;
                    }elseif($row['warranty_type'] == 'No warranty'){
                        $warranty_type = 7;
                    }

                    if(!empty($vendor_details && $brand_details && $parent_category && $child_category && $sub_child_category && $variation_details)){
                        if($row['sale_price'] >= $row['cost_price']){
                            $response = 1;
                        }else{
                            if(!empty($row['promotion_start_date'] && $row['promotion_end_date'])){
                                $from_date = date('Y-m-d', strtotime($row['promotion_start_date']));
                                $to_date = date('Y-m-d', strtotime($row['promotion_end_date']));
                            }else{
                                $from_date = NULL;
                                $to_date = NULL;
                            }
                            
                            //Set Field data according to table columns
                            $data = array(
                                'ip_address' => $request->ip(),
                                'admin_id' => $request->session()->get('id'),
                                'user_id' => $vendor_details->vendor_id,
                                'name' => $row['name'],
                                'slug' => preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strtolower($row['name'].'-'.$vendor_details->store_name))),
                                'sku_code' => $row['sku_code'],
                                'high_light' => $row['highlight'],
                                'description' => $row['description'],
                                'warranty_type' => $warranty_type,
                                'what_in_the_box' => $row['whats_in_the_box'],
                                'weight' => $row['weight'],
                                'length' => $row['length'],
                                'width' => $row['width'],
                                'height' => $row['height'],
                                'variation_id' => $variation_details->variation_id,
                                'regural_price' => $row['cost_price'],
                                'sale_price' => $row['sale_price'],
                                'quantity' => $row['quantity'],
                                'from_date' => $from_date,
                                'to_date' => $to_date,
                                'status' => 0,
                                'is_approved' => 0,
                                'video_url' => $row['video'],
                                'meta_keywords' => $row['meta_keywords'],
                                'meta_description' => $row['meta_description'],
                                'created_date' => date('Y-m-d'),
                                'created_time' => date('h:i:s'),
                            );

                            //Query For Inserting Data
                            $product_id = DB::table('tbl_products')
                                              ->insertGetId($data); 

                            //Upload Product Image
                            $image = uniqid().'.jpeg';
                            $image_path = file_put_contents($_SERVER["DOCUMENT_ROOT"].'/public/assets/admin/images/ecommerce/products/'.$image, file_get_contents($row['featured_image']));

                            //Set Field data according to table columns
                            $data = array(
                                'ip_address' => $request->ip(),
                                'user_id' => $vendor_details->vendor_id,
                                'product_id' => $product_id,
                                'featured_image' => $image,
                            ); 
                            
                            //Query For Inserting Data
                            $featured_image = DB::table('tbl_products_featured_images')
                                            ->insertGetId($data);

                            if(!empty($row['product_image_1'])){
                                //Upload Product Image
                                $image = uniqid().'.jpeg';
                                $image_path = file_put_contents($_SERVER["DOCUMENT_ROOT"].'/public/assets/admin/images/ecommerce/products/'.$image, file_get_contents($row['product_image_1']));

                                //Set Field data according to table columns
                                $data = array(
                                    'ip_address' => $request->ip(),
                                    'user_id' => $vendor_details->vendor_id,
                                    'product_id' => $product_id,
                                    'image' => $image,
                                ); 
                                
                                //Query For Inserting Data
                                $images = DB::table('tbl_products_images')
                                                ->insertGetId($data);
                            }

                            if(!empty($row['product_image_2'])){
                                //Upload Product Image
                                $image = uniqid().'.jpeg';
                                $image_path = file_put_contents($_SERVER["DOCUMENT_ROOT"].'/public/assets/admin/images/ecommerce/products/'.$image, file_get_contents($row['product_image_2']));

                                //Set Field data according to table columns
                                $data = array(
                                    'ip_address' => $request->ip(),
                                    'user_id' => $vendor_details->vendor_id,
                                    'product_id' => $product_id,
                                    'image' => $image,
                                ); 
                                
                                //Query For Inserting Data
                                $images = DB::table('tbl_products_images')
                                                ->insertGetId($data);
                            }

                            if(!empty($row['product_image_3'])){
                                //Upload Product Image
                                $image = uniqid().'.jpeg';
                                $image_path = file_put_contents($_SERVER["DOCUMENT_ROOT"].'/public/assets/admin/images/ecommerce/products/'.$image, file_get_contents($row['product_image_3']));

                                //Set Field data according to table columns
                                $data = array(
                                    'ip_address' => $request->ip(),
                                    'user_id' => $vendor_details->vendor_id,
                                    'product_id' => $product_id,
                                    'image' => $image,
                                ); 
                                
                                //Query For Inserting Data
                                $images = DB::table('tbl_products_images')
                                                ->insertGetId($data);
                            }

                            if(!empty($row['product_image_4'])){
                                //Upload Product Image
                                $image = uniqid().'.jpeg';
                                $image_path = file_put_contents($_SERVER["DOCUMENT_ROOT"].'/public/assets/admin/images/ecommerce/products/'.$image, file_get_contents($row['product_image_4']));

                                //Set Field data according to table columns
                                $data = array(
                                    'ip_address' => $request->ip(),
                                    'user_id' => $vendor_details->vendor_id,
                                    'product_id' => $product_id,
                                    'image' => $image,
                                ); 
                                
                                //Query For Inserting Data
                                $images = DB::table('tbl_products_images')
                                                ->insertGetId($data);
                            }
                            
                            //Set Field data according to table columns
                            $data = array(
                                'ip_address' => $request->ip(),
                                'user_id' => $vendor_details->vendor_id,
                                'product_id' => $product_id,
                                'brand_id' => $brand_details->brand_id,
                            ); 
                            
                            //Query For Inserting Data
                            $brand = DB::table('tbl_product_brands')
                                            ->insertGetId($data);

                            //Set Field data according to table columns
                            $data = array(
                                'ip_address' => $request->ip(),
                                'user_id' => $vendor_details->vendor_id,
                                'product_id' => $product_id,
                                'parent_id' => $parent_category->category_id,
                                'child_id' => $child_category->category_id,
                                'sub_child_id' => $sub_child_category->category_id,
                            ); 
                            
                            //Query For Inserting Data
                            $categories = DB::table('tbl_product_categories')
                                            ->insertGetId($data);

                            if(!empty($product_id)){
                                $response = 2;
                            }else{
                                $response = 3;
                            }
                        }
                    }else{
                        $response = 4;
                    }
                }

                if($response == 1){
                    //Flash Error Msg
                    $request->session()->flash('alert-danger', 'Special price must be less than the price.');
                }elseif($response == 2){
                    //Flash Success Msg
                    $request->session()->flash('alert-success', 'Product has been sent successfully.');
                }elseif($response == 3){
                    //Flash Error Msg
                    $request->session()->flash('alert-danger', "There is Something wen't wrong with your imported sheet.");
                }elseif($response == 4){
                    //Flash Error Msg
                    $request->session()->flash('alert-danger', "Data is invalid in your given imported file.");
                }

                //Redirect
                return redirect()->back(); 
            }else{
                //Flash Error Msg
                $request->session()->flash('alert-danger', "File should contain atleast one product.");

                //Redirect
                return redirect()->back();
            }
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }

    function update_visibility(Request $request, $id, $status){
        if(!empty($request->session()->has('id') && $request->session()->get('role') == 0 && $id)){
            $query = DB::table('tbl_products')
                         ->where('id', $id)
                         ->update(array('is_approved' => $status));

            if(!empty($query == 1)){
                //Flash Erro Msg
                $request->session()->flash('alert-success', 'Product Avaliability has been updated successfully');
            }else{
                //Flash Erro Msg
                $request->session()->flash('alert-danger', 'Something went wrong !!');
            }

            //Redirect
            return redirect()->back();
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }
}