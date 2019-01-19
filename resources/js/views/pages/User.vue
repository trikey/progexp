<template>
  <div>
    User: {{ user.email }}
  </div>
</template>
<script>
export default {
  data() {
    return {
      user: {
        email: '',
      },
    };
  },
  async mounted() {
    try {
      const res = await this.$http.get('/api/auth/user');
      this.user = res.body.data;
    }
    catch (error) {
      // if (error.body.error === 'Unauthorized') {
      // }
    }
  },
};
</script>
