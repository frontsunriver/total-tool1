<template>
  <div class="box box-info">
             <div class="box-header with-border">
               <h3 class="box-title">Set the front end theme</h3>
             </div>

             <div class="box-body">
              <draggable v-model="product_section_orderss" @change="update">
                  <div class="input-group" v-for="product_section_order in product_section_orderss">
                     <span class="input-group-addon">{{product_section_order['order']}}</span>
                     <img style="width:100%"  v-bind:src="'../../'+product_section_order['image_path']">
                     {{product_section_order['name']}}
                     <span class="input-group-addon">
                       <a><i class="fa fa-list-ul"></i></a>
                       <input type="checkbox" name="" value="product_section_order['status']">
                     </span>
                   </div>


                 </draggable>


             </div>
             <!-- /.box-body -->
  </div>
</template>

<script>
import draggable from 'vuedraggable'

    export default {
      components: {
        draggable,
        },
        props: [
          'product_section_orders'
        ],
        data() {
          return {
              product_section_orderss : this.product_section_orders
          }
        },

        methods: {
           update(){
             this.product_section_orderss.map((product_section_orders, index) => {
               product_section_orders.order = index + 1;
             })

             axios.post('reorder', {

               product_section_orders : this.product_section_orderss

             }).then((response) => {

             })
           }
        },

        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
