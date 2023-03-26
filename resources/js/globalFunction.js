
class calcGoute {

  constructor(out, temp){
    this.output = out;
    this.temp = temp;
  }

  add(){
    let id  = this.temp.id,
        qte = this.temp.qte;

    if(id != null && qte > 0){

      let goute = this.search_id(id, this.show_product.product_goute, 'id');
      let data = {product_goute_id: id, qte: qte, product_goute: goute}
      let if_exists = this.search_id(id, this.order_product.order_detail_goute, 'product_goute_id')

      if(if_exists){
        let gout = this.order_product.order_detail_goute[if_exists.index];
        gout.qte = data.qte;
        gout.edite = 'update';

      }else{
        this.order_product.order_detail_goute.push(data);
      }
    }
    this.prod_goute = {};
    this.count_goute();
  }

  delete(){

  }

  count(){

  }
}
