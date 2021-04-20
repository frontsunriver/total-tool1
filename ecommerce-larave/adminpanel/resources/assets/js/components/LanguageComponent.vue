<template>
  <div>
    <ul class="dropdown-menu">
      <li v-for="language in languages">
        <a href="#" @click="update(language.languages_id)">
          <img  style="margin-left:10px; margin-right:10px;":src="language.image_path" width="17px" />
          {{language.name}}
        </a>
      </li>
    </ul>
  </div>
</template>

<script>
    export default {
        props: [
          'languages'
        ],
        data() {
          return {
              // languages : this.languages
          }
        },

        methods: {
           update(language_id){
             console.log(language_id);
             // this.product_section_orderss.map((product_section_orders, index) => {
             //   product_section_orders.order = index + 1;
             // })
             //
             // axios.post('reorder', {
             //
             //   product_section_orders : this.product_section_orderss
             //
             // }).then((response) => {
             //
             // })
           }
        },

        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
