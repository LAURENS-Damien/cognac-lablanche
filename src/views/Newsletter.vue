<template>
    <div class="container-fluid">
        <h1>Inscription à la newsletter</h1>
        <b-form id="post-newsletter" @submit.prevent="postForm" @reset="resetForm">
            <b-form-group id="email-group" label="Email (obligatoire) :" label-for="email">
                <b-form-input
                        id="email"
                        v-model="email"
                        type="email"
                        required
                        placeholder="Renseigner un email"
                ></b-form-input>
            </b-form-group>

            <b-form-group id="name-group" label="Nom :" label-for="name">
                <b-form-input
                        id="name"
                        v-model="name"
                        placeholder="Renseigner un nom"
                ></b-form-input>
            </b-form-group>

            <b-form-group id="surname-group" label="Prénom :" label-for="surname">
                <b-form-input
                        id="surname"
                        v-model="surname"
                        placeholder="Renseigner un prénom"
                ></b-form-input>
            </b-form-group>

            <b-form-group id="address-group" label="Adresse :" label-for="address">
                <b-form-input
                        id="address"
                        v-model="address"
                        placeholder="Renseigner une adresse"
                ></b-form-input>
            </b-form-group>

            <b-form-group id="postal-code-group" label="Code postal :" label-for="postal-code">
                <b-form-input
                        id="postal-code"
                        type="number"
                        v-model="postalCode"
                        placeholder="Renseigner un code postal"
                ></b-form-input>
            </b-form-group>

            <b-form-group id="town-group" label="Ville :" label-for="town">
                <b-form-input
                        id="town"
                        v-model="town"
                        placeholder="Renseigner une ville"
                ></b-form-input>
            </b-form-group>

            <b-form-group id="phone-number-group" label="Numéro de téléphone :" label-for="phone-number">
                <b-form-input
                        id="phone-number"
                        type="tel"
                        v-model="phoneNumber"
                        placeholder="Renseigner un numéro de téléphone"
                ></b-form-input>
            </b-form-group>

            <b-form-group id="remarks-group" label="Remarques :" label-for="remarks">
                <b-form-input
                        id="remarks"
                        v-model="remarks"
                        placeholder="Renseigner une remarque"
                ></b-form-input>
            </b-form-group>
            <div class="form-buttons text-center py-3">
                <b-button class="mr-1" type="submit" variant="primary">Soumettre</b-button>
                <b-button type="reset" variant="danger">Réinitialiser</b-button>
            </div>
        </b-form>
    </div>
</template>

<script lang="ts">
  import { Component, Vue } from 'vue-property-decorator';
  import * as Constants from '@/ts/constants';
  import axios from 'axios';

  @Component
  export default class Newsletter extends Vue {
    private email = '';
    private name = '';
    private surname = '';
    private address = '';
    private postalCode = '';
    private town = '';
    private phoneNumber = '';
    private remarks = '';

    public postForm() {
        axios.post(Constants.URL_NEWSLETTER_SUSCRIBE, {
          email: this.email,
          name: this.name,
          surname: this.surname,
          profile: {
            1 : this.address,
            2: this.postalCode,
            3: this.town,
            4: this.phoneNumber,
            5: this.remarks,
          } })
          .then((response) => {
            // Enregistrement OK
            if (response.status === 200) {
              alert('Enregistrement effectué avec succès');
            }
            this.resetForm();
          })
          .catch((error) => {
            // Erreur sur l'adresse mail
            if (error.response.status === 400) {
              alert(error.response.data.message);
            } else {
              alert('Une erreur s\'est produite : ' + error.response.data.message);
            }
          });
    }

    public resetForm() {
      this.email = '';
      this.name = '';
      this.surname = '';
      this.address = '';
      this.postalCode = '';
      this.town = '';
      this.phoneNumber = '';
      this.remarks = '';
    }
  }
</script>
