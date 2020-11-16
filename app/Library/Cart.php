<?php
namespace App\Library;

class Cart
{
    //item
    public $items=[];
    //total
    public $total_quanlity=0;
    public $total_price=0;

     public function __construct()
     {  //kiểm tra có session cart , không thì gán bằng rỗng
         $this->items=session('cart') ? session('cart') :[];

        $this->total_price=$this->get_total_price();
        $this->total_quanlity=$this->get_total_quantity();

     }
     //add product
     public function add($product,$quantity=1)
     {
        //lọc thông tin item;

        //dd($product);
        $item= [
            'id'=>$product->id,
            'name'=>$product->name,
            //giá khuyến mãi nếu có thì lấy ok không thì lấy giá gốc :<3
            'price'=>$product->price_sale > 0 ?$product->price_sale:$product->price,
            'image'=>$product->image,
            'quantity'=>$quantity,
        ];
        //gắn mãng 2 chiều lưu nhiều sản phẩm

        //dd($item);
        //dd( $this->item);
        //lưu vào session items
        //mua thêm
        if(isset($this->items[$product->id]))
        {
            $this->items[$product->id]['quantity']+=$quantity;
        }
        else{
            $this->items[$product->id]=$item;
        }
        session(['cart'=>$this->items]);

     }
     //
     public function remove($id)
     {
        if(isset($this->items[$id]))
        {
            unset($this->items[$id]);
        }
        session(['cart'=>$this->items]);
     }
     public function update($id,$quantity=1)
     {
        if(isset($this->items[$id]))
        {
            $this->items[$id]['quantity']=$quantity;

        }

        session(['cart'=>$this->items]);
     }
     public function clear()
     {  //gắn thành mảng rỗng nha
        session(['cart'=>[]]);
     }

     private function get_total_price()
     {
         $t=0;
         foreach($this->items as $item)
         {
             $t+=$item['price']*$item['quantity'];

         }
        return $t;
     }
     //private dung trong class
     private function get_total_quantity()
     {
        $t=0;
         foreach($this->items as $item)
         {
             $t+=$item['quantity'];

         }
        return $t;
     }

}
