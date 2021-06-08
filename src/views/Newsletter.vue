<template>
  <div class="newsletter container-fluid limit-max-width my-3 my-lg-5">
    <h1 class="mb-4">Inscription à la newsletter</h1>
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
import {Component, Mixins, Vue} from 'vue-property-decorator';
import * as Constants from '@/ts/constants';
import MetaTitleMixins from '@/ts/mixins/MetaTitleMixins';
import MetaDescriptionMixins from '@/ts/mixins/MetaDescriptionMixins';

@Component
export default class Newsletter extends Mixins(MetaTitleMixins, MetaDescriptionMixins) {
  public metaTitle = 'Inscription à la newsletter - Cognac LABLANCHE';
  public metaDescription = 'Inscrivez vous à notre newsletter';
  private email = '';
  private name = '';
  private surname = '';
  private address = '';
  private postalCode = '';
  private town = '';
  private phoneNumber = '';
  private remarks = '';

  public postForm() {
    this.axios.post(Constants.URL_NEWSLETTER_SUSCRIBE, {
      email: this.email,
      name: this.name,
      surname: this.surname,
      profile_1: this.address,
      profile_2: this.postalCode,
      profile_3: this.town,
      profile_4: this.phoneNumber,
      profile_5: this.remarks,
    })
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
