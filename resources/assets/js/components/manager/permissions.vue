<template>
    <div class="columns">
        <div class="column is-6 is-offset-3">
            <form action="">

            </form>
        </div>
    </div>
</template>

<script>
  import axios from 'axios';

  export default {
    data () {
      return {
        permissions: {},
      };
    },
    props: [],
    methods: {},
    computed: {},
    mounted () {
      let vm = this;
      axios.get(routes.route('get.user.permissions'))
        .then(function (response) {
          vm.permissions = response.data.permissions;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    created () {

    },
    destroyed () {

    }
  };
</script>
