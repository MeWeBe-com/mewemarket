<?php


class product_model extends CI_Model
{

	public function GetProductsByCategoryId($id,$limit = Null,$start = Null)
	{
		$this->db->select('cat.category_name,pro.*');
		$this->db->from('products as pro');
		$this->db->join('categories as cat' ,'cat.category_id = pro.category_id');
		$this->db->where('pro.category_id',$id);
		$this->db->order_by('pro.product_id','desc');

		$this->db->limit($limit, $start);

		$query = $this->db->get();
		return $query->result();
	}

	public function GetProductsByProductId($id)
	{
		$this->db->select('cat.category_name,pro.*');
		$this->db->from('products as pro');
		$this->db->join('categories as cat' ,'cat.category_id = pro.category_id');
		$this->db->where('pro.product_id',$id);

		$query = $this->db->get();
		return $query->result();
	}

	public function GetProductsForHome()
	{
		$this->db->select('cat.category_name,pro.*');
		$this->db->from('products as pro');
		$this->db->join('categories as cat' ,'cat.category_id = pro.category_id');
		$this->db->order_by('pro.product_id','desc');
		$this->db->limit(3);

		$query = $this->db->get();
		return $query->result();
	}

	public function CheckProductOfUserExist($product_id = NULL,$user_id = NULL,$package_id = NULL)
	{
		$this->db->select('*');
		$this->db->from('billing');
		$this->db->where('user_id' ,$user_id);
		$this->db->where('product_id' ,$product_id);
		$this->db->where('package_id' ,$package_id);
		$this->db->order_by('billing.id','desc');

		$query = $this->db->get();
		return $query->result();
	}

	public function SearchProducts($keyword)
	{
		$this->db->select('cat.category_id,cat.category_name,pro.payment_type,pro.key_benefits,pro.featured_tag,pro.product_id,pro.rating,pro.total_sales,pro.product_type,pro.product_name,pro.demo_link,pro.featured_image,pro.compatible_browsers,pro.files_included,pro.software_framework,pro.software_version,pro.created_at');
		$this->db->from('products as pro');
		$this->db->join('categories as cat' ,'cat.category_id = pro.category_id');
		$this->db->like('pro.product_name',$keyword);
		//$this->db->or_like('pro.product_type',$keyword);

		$query = $this->db->get();
		return $query->result();
	}

	public function SearchProductsWithFilters($keyword = NULL,$min_price = NULL,$max_price = NULL)
	{
		$this->db->select('cat.category_id,cat.category_name,pro.product_id,pro.product_type,pro.product_name,pro.demo_link,pro.featured_image,pro.compatible_browsers,pro.files_included,pro.software_framework,pro.software_version,pro.created_at');
		$this->db->from('products as pro');
		$this->db->join('categories as cat' ,'cat.category_id = pro.category_id');

		if(!empty($min_price) && !empty($max_price)){
			$this->db->where("pro.product_price BETWEEN '$min_price' AND '$max_price'");
		}

		$this->db->like('pro.product_name',$keyword);
		$this->db->or_like('pro.product_type',$keyword);

		$query = $this->db->get();

		return $query->result();
	}

	public function UserProducts($id)
	{
		$this->db->select('product_id,user_id,status,subscription_id,app_url');
		$this->db->from('billing');
		$this->db->where('user_id',$id);
		$this->db->order_by('id','desc');
		$this->db->group_by('product_id');
		$query = $this->db->get();
		return $query->result();
	}

	public function UserPurchasedProducts($id = NULL, $limit = NULL, $start = NULL)
	{
		$this->db->select('*');
		$this->db->from('billing');
		$this->db->join('products','products.product_id = billing.product_id');
		$this->db->where('billing.user_id',$id);

		$this->db->order_by('billing.id','desc');
		$this->db->group_by('products.product_id');

		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $query->result();
	}

	public function UserProductsByProductID($id = NULL,$product_id = NULL)
	{
		$this->db->select('product_id,user_id,status,subscription_id,app_url');
		$this->db->from('billing');
		$this->db->where('user_id',$id);
		$this->db->where('product_id',$product_id);
		$query = $this->db->get();
		return $query->result();
	}

	public function UserFavourites($id)
	{
		$this->db->select('product_id,user_id');
		$this->db->from('user_favourite');
		$this->db->where('user_id',$id);

		$query = $this->db->get();
		return $query->result();
	}

	public function GetProducts()
	{
		$this->db->select('*');
		$this->db->from('products');
		$this->db->join('categories','products.category_id = categories.category_id');

		$query = $this->db->get();
		return $query->result();
	}

	public function GetBillingDetails($id)
	{
		$this->db->select('*');
		$this->db->from('billing as bill');
		$this->db->join('products as pro','pro.product_id = bill.product_id');
		$this->db->where('bill.user_id',$id);
		$this->db->order_by('bill.id','desc');
		$this->db->group_by('pro.product_id');

		$query = $this->db->get();
		return $query->result();
	}

    public function InsertQuery($table_name, $PostedData)
    {

      	$this->db->insert($table_name,$PostedData);

    		if($this->db->affected_rows()>0 )
    		{
    			return $this->db->insert_id();
    		}
    		else
    		{
    			return "Fail";
    		}
    }

	public function SelectQuery($table_name = NULL)
	{
		$this->db->select('*');
		$this->db->from($table_name);

		$query = $this->db->get();
		return $query->result();
	}



    public function SelectQueryWithClause($table_name = NULL,$column_name = NULL,$clause = NULL)
    {
      $this->db->select('*');
      $this->db->from($table_name);
      $this->db->where($column_name,$clause);
      
      $query = $this->db->get();
      return $query->result();
    }

    public function GetProductImages($id = NULL)
    {
      $this->db->select('*');
      $this->db->from('product_images');
      $this->db->where('product_id',$id);

      $query = $this->db->get();
      return $query->result();
    }

      public function UpdateQuery($table_name = NULL,$column_name = NULL,$clause = NULL,$PostedData = NULL)
    {

        $this->db->set($PostedData);
        $this->db->where($column_name, $clause);
        $this->db->update($table_name);

        if($this->db->affected_rows() > 0 )
        {
            return true;
        }
        else
        {
            return "Fail";
        }
    }

    public function DeleteQuery($table_name = NULL,$column_name = NULL,$clause = NULL)
    {

        $this->db->where($column_name, $clause);
        $this->db->delete($table_name);
        //DELETE FROM table_name WHERE column_name = clause;

        if($this->db->affected_rows()>0 )
        {
            return true;
        }
        else
        {
            return "Fail";
        }
    }


	public function GetProductsForUsersDetails($id)
	{
		$this->db->select('cat.category_name,pro.*,u_pro.*');
		$this->db->from('billing as u_pro');
		$this->db->join('products as pro' ,'pro.product_id = u_pro.product_id');
		$this->db->join('categories as cat' ,'cat.category_id = pro.category_id');
		$this->db->where('u_pro.user_id',$id );
		$status = array('activate', 'suspend', 'cancel');
		$this->db->where_in('u_pro.status',$status );
		$this->db->order_by('u_pro.id','desc');
		$this->db->group_by('pro.product_id');

		$query = $this->db->get();
		return $query->result();
	}

	public function GetFavouritesForUsersDetails($id = NULL,$limit = NULL, $start = NULL)
	{
		$this->db->select('cat.category_name,pro.*');
		$this->db->from('user_favourite as u_pro');
		$this->db->join('products as pro' ,'pro.product_id = u_pro.product_id');
		$this->db->join('categories as cat' ,'cat.category_id = pro.category_id');
		$this->db->where('u_pro.user_id',$id );
		$this->db->order_by('u_pro.favourite_id','desc');

		$this->db->limit($limit, $start);

		$query = $this->db->get();
		return $query->result();
	}

	public function GetCountrows($table_name = NULL,$column_name = NULL,$clause = NULL)
	{
		$this->db->select('count(*) as total');
		$this->db->from($table_name);
		$this->db->where($column_name,$clause);

		$query = $this->db->get();
		return $query->result();
	}

	public function UpdateSales($product_id)
	{

		$this->db->set('total_sales',`total_sales`+ 1);
		$this->db->where('product_id', $product_id);
		$this->db->update('products');

		if($this->db->affected_rows() > 0 )
		{
			return true;
		}
		else
		{
			return "Fail";
		}
	}

}
