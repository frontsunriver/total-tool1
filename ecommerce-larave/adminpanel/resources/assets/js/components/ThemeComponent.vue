<template>
  <div class="container-fluid">
   <div style="margin-top:10px;">
    <div  v-if="this.responses.themeSetResponse == 1" class="alert alert-success alert-dismissible">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Success!</strong> Theme Has been activated!.
    </div>
    <div  v-if="this.responses.themeSetResponse == 0" class="alert alert-danger alert-dismissible">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Opps!</strong> No Change has been made!.
    </div>
    <div class="row">
      <h2 class="page_build_heading">Home Page Builder</h2>
      <p class="page_build_paragraph">Laravel Ecommerce comes with home page builder, you can choose header, footer, slider and banner style as per your client needs. We have designed many sections. You can drag and drop each section to set the arrangement of sections for your site home page. In case, you don't want to show any purticular section, you can hide it as well. We shall add more sections in next updates.</p>
    </div>
  </div>
    <div class="row">
      <div class="col-xs-12 text-right">
        <a :href="'/admin/webPagesSettings'+'/1'" class="btn  btn-danger btn_custom_style1"> Cancel </a>&nbsp;
        <button  @click="setTheme()" class="btn btn-primary btn_custom_style1">Apply Changes </button>
      </div>
    </div>
      <div class="row">
        <div class="col-sm-3 col-md-6 col-lg-4">
          <div class="container">
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" id="closemodal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h3 class="modal-title text-primary" id="myModalLabel">Choose Header </h3>
                        </div>
                        <div class="modal-body manufacturer-image-embed">
                          <img data-dismiss="modal" v-for="header in headers" @click="HeaderSetter(header)" style="width:100%"  v-bind:src="'/'+header.image">
                        </div>
                    </div>
                </div>
            </div>
          </div>
          <div class="container">
            <!-- Modal -->
            <div class="modal fade" id="carousalModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" id="closemodal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h3 class="modal-title text-primary" id="myModalLabel">Choose Carousal </h3>
                        </div>
                        <div class="modal-body manufacturer-image-embed">
                          <img data-dismiss="modal" v-for="carousal in carousals" @click="CarousalSetter(carousal)" style="width:100%"  v-bind:src="'/'+carousal.image">
                        </div>
                    </div>
                </div>
            </div>
          </div>
          <div class="container">
            <!-- Modal -->
            <div class="modal fade" id="bannerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" id="closemodal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h3 class="modal-title text-primary" id="myModalLabel">Choose Banner </h3>
                        </div>
                        <div class="modal-body manufacturer-image-embed active">
                          <img data-dismiss="modal" v-for="banner in banners" @click="BannerSetter(banner)" style="width:100%"  v-bind:src="'/'+banner.image">
                        </div>
                    </div>
                </div>
            </div>
          </div>
          <div class="container">
            <!-- Modal -->
            <div class="modal fade" id="footerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" id="closemodal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h3 class="modal-title text-primary" id="myModalLabel">Choose Footer </h3>
                        </div>
                        <div class="modal-body manufacturer-image-embed">
                          <img data-dismiss="modal" v-for="footer in footers" @click="FooterSetter(footer)" style="width:100%"  v-bind:src="'/'+footer.image">
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
        <div class="col-sm-12 dragable-content">
          <div class="row">
              <div class="col-sm-12 dragable-box" id="header_img">
                <div class="row">
                    <div class="col-sm-12">
                      <img   style="width:100%" v-for="header in headers" v-if="header.id == current_theme.header && path_of_header == ''" v-bind:src="'/'+header.image">
                      <img   style="width:100%" v-if="path_of_header != ''" v-bind:src="'/'+path_of_header">
                    </div>
                    <div class="hover_option header_options">
                      <button data-toggle="modal" data-target="#myModal" class="btn  btn-primary btn_custom_style">
                        <i data-toggle="tooltip" title="Choose Header"  class="fa fa-check-square-o"></i> &nbsp;Choose
                      </button>
                    </div>
                  </div>
              </div>
              <div class="col-sm-12 dragable-box" id="carousal_img">
                <div class="row">
                    <div class="col-sm-12">
                      <img   style="width:100%" v-for="carousal in carousals" v-if="carousal.id == current_theme.carousel && path_of_carousal == ''" v-bind:src="'/'+carousal.image">
                      <img   style="width:100%" v-if="path_of_carousal != ''" v-bind:src="'/'+path_of_carousal">
                    </div>
                    <div class="hover_option carousal_options">
                      <button data-toggle="modal" data-target="#carousalModal" class="btn  btn-primary btn_custom_style">
                        <i class="fa fa-check-square-o"  data-toggle="tooltip" title="Choose Carousal"></i> &nbsp;Choose
                      </button>                    
                      
                    </div>
                  </div>
              </div>
              <div class="col-sm-12">
                  <div class="row">
                  <draggable v-model="product_section_orderss" @change="update">
                    <div :id="['banner_img_' + product_section_order.order]" class="col-sm-12 dragable-box dragable-box-cursor" v-for="product_section_order in product_section_orderss">
                      <div class="row" >
                        <div class="col-sm-12">
                             <img v-if="product_section_order['id'] != 1  && product_section_order['status'] == 1" style="width:100%" v-bind:alt="product_section_order['name']" v-bind:src="'/'+product_section_order['image']">
                             <img v-if="product_section_order['id'] != 1 && product_section_order['status'] == 0" style="width:100%" v-bind:alt="product_section_order['name']" v-bind:src="'/'+product_section_order['disabled_image']">
                             <img v-for="banner in banners" style="width:100%" v-if="product_section_order['id'] == 1 && product_section_order['status'] == 1 && banner.id == current_theme.banner && path_of_banner == ''"  v-bind:alt="product_section_order['name']" v-bind:src="'/'+banner.image">
                             <img v-for="banner in banners" style="width:100%" v-if="product_section_order['id'] == 1 && product_section_order['status'] == 0 && banner.id == current_theme.banner && path_of_banner == ''"  v-bind:alt="product_section_order['name']" v-bind:src="'/images/prototypes/banner1-cross.jpg'">
                             <img style="width:100%" v-if="product_section_order['id'] == 1 && product_section_order['status'] == 1 && path_of_banner != ''"  v-bind:src="'/'+path_of_banner">
                             <img style="width:100%" v-if="product_section_order['id'] == 1 && product_section_order['status'] == 0 && path_of_banner != ''"  v-bind:src="'/images/prototypes/banner1-cross.jpg'">
                        </div>

                        <div :class="['hover_option banner_options_' + product_section_order.order]">
                          <div class="" v-if="product_section_order['id'] == 1 ">
                            <button data-toggle="modal" data-target="#bannerModal" class="btn  btn-primary btn_custom_style">
                              <i class="fa fa-check-square-o"  data-toggle="tooltip" title="Choose Banner"></i> &nbsp; Choose
                            </button>
                          </div>
                          <div class="">
                            <button @click="changeStatus(product_section_order['id'])"class="btn  btn-primary btn_custom_style">
                              <i v-if="product_section_order['status'] == 1"class="fa fa-eye"  data-toggle="tooltip" title="Deactive this Section"></i>
                              <i v-if="product_section_order['status'] == 0"class="fa fa-eye" data-toggle="tooltip" title="Active this Section"></i> &nbsp; Show/Hide
                            </button>
                          </div>
                          
                        </div>
                      </div>
                      </div>
                  </draggable>
                  </div>
                </div>
              <div class="col-sm-12 dragable-box" id="footer_img">
               <div class="row">
                <div class="col-sm-12">
                  <img   style="width:100%" v-for="footer in footers" v-if="footer.id == current_theme.footer && path_of_footer == ''" v-bind:src="'/'+footer.image">
                  <img   style="width:100%" v-if="path_of_footer != ''" v-bind:src="'/'+path_of_footer">
                </div>
                <div class="hover_option footer_options">
                  <button data-toggle="modal" data-target="#footerModal" class="btn  btn-primary btn_custom_style">
                    <i class="fa fa-check-square-o"  data-toggle="tooltip" title="Choose Footer"></i> &nbsp; Choose
                  </button>
                </div>

               </div>
              </div>
           </div>
        </div>
        <div class="box-footer text-right">
            <a :href="'/admin/webPagesSettings'+'/1'" class="btn  btn-danger btn_custom_style1"> Cancel </a>&nbsp;
            <button  @click="setTheme()" class="btn btn-primary btn_custom_style1">Apply Changes </button>
        </div>
      </div>


    </div>

</template>

<script>

import draggable from 'vuedraggable'
import axios from 'axios'
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

    export default {
      components: {
        draggable,
        },
        props: [
          'data'
        ],
        data() {
          return {
              formRequest: {
                header_id : this.data.current_theme.header,
                carousel_id : this.data.current_theme.carousel,
                banner_id : this.data.current_theme.banner,
                banner_two_id : this.data.current_theme.banner_two,
                footer_id : this.data.current_theme.footer,
                cart_id : 1,
                news_id : 1,
                detail_id : 1,
                shop_id : 1,
                contact_id : 1
              },
              fileupload : '',
              responses:{
                themeSetResponse : -1
              },
              headers : this.data.data.headers,
              carousals : this.data.data.carousels,
              banners : this.data.data.banners,
              product_section_orderss : this.data.data.product_section_order,
              footers : this.data.data.footers,
              current_theme : this.data.current_theme,
              banners_for_styles :  this.data.data.homeBanners,
              path_of_header : '',
              path_of_carousal : '',
              path_of_banner : '',
              banner_id_for_href : this.data.current_theme.banner,
              banner_two_id_for_href : this.data.current_theme.banner_two,
              path_of_footer : ''

          }
        },

        methods: {
           HeaderSetter(header){
             this.path_of_header = header.image;
             this.formRequest.header_id = header.id;
           },
           CarousalSetter(carousal){
             this.path_of_carousal = carousal.image;
             this.formRequest.carousel_id = carousal.id;
           },
           BannerSetter(banner){
             this.path_of_banner = banner.image;
             this.formRequest.banner_id = banner.id;
             this.banner_id_for_href = banner.id;
           },
           FooterSetter(footer){
             this.path_of_footer = footer.image;
             this.formRequest.footer_id = footer.id;
           },
           update(){
             this.product_section_orderss.map((product_section_orders, index) => {
               product_section_orders.order = index + 1;
             })
             axios.post('reorder', {
               product_section_orders : this.product_section_orderss
              }).then((response) => {
             })
           },
           changeStatus(id){
             axios.post('changestatus', {
                    id: id,
                    product_section_orders : this.product_section_orderss

                  })
                  .then(response => {
                    if(response.status===200){
                      this.product_section_orderss = response.data;
                    }
                  })
                  .catch(function (error) {
                    console.log(error);
                  });
           },
           setTheme(){
             axios.post('setting/set', {
                    request: this.formRequest
                  })
                  .then(response => {
                    if(response.status===200){
                      this.responses.themeSetResponse = response.data;
                       window.scrollTo(0,0);
                    }
                  })
                  .catch(function (error) {
                    console.log(error);
                  });
           }

        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
