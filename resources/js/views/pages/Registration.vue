<template>
  <div>
    <v-container fluid fill-height>
      <v-layout align-center justify-center>
        <v-flex xs12 sm8 md4>
          <v-card class="elevation-12">
            <v-toolbar dark color="primary">
              <v-toolbar-title>Register form</v-toolbar-title>
              <v-spacer></v-spacer>
            </v-toolbar>
            <v-card-text>
              <v-form ref="form" v-model="valid" validattion>
                <v-text-field
                  prepend-icon="person"
                  label="Email"
                  v-validate="'required|email'"
                  v-model="email"
                  :error-messages="errors.collect('email')"
                  data-vv-name="email"
                  required
                >
                </v-text-field>
                <v-text-field prepend-icon="lock"
                              label="Password"
                              id="password"
                              type="password"
                              v-validate="'required|min:5'"
                              v-model="password"
                              :error-messages="errors.collect('password')"
                              data-vv-name="password"
                              ref="password"
                              required
              >
              </v-text-field>
                <v-text-field prepend-icon="lock"
                              label="Confirm password"
                              id="confirmPassword"
                              v-validate="'required|confirmed:password'"
                              v-model="confirmPassword"
                              :error-messages="errors.collect('confirm_password')"
                              data-vv-name="confirm_password"
                              data-vv-as="password"
                              type="password"
                              required
                >
                </v-text-field>
              </v-form>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="primary" @click="register" :disabled="!valid">Create account</v-btn>
            </v-card-actions>
          </v-card>
        </v-flex>
      </v-layout>
    </v-container>
  </div>
</template>
<script>
  import { mapGetters } from 'vuex';

  export default {
    mounted() {
      if (this.loggedIn) {
        this.redirect();
      }
    },
    data() {
      return {
        email: '',
        password: '',
        confirmPassword: '',
        valid: false
      };
    },
    computed: {
      ...mapGetters('auth', [
        'loggedIn',
      ])
    },
    methods: {
      register(){
        if (this.$refs.form.validate()){
          const { email, password } = this;
          this.$store.dispatch('auth/register', { email, password }).then(this.redirect)
        }
      },
      redirect() {
        if (this.$route.query.redirect) {
          this.$router.push({ path: this.$route.query.redirect });
        }
        else {
          this.$router.push({ name: 'index' });
        }
      },
    },
  };
</script>
<style scoped="">


</style>
