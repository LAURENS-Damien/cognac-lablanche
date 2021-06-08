import {Vue, Component} from 'vue-property-decorator';

@Component
export default class MetaDescriptionMixins extends Vue {
  public created() {
    const metaDescription = this.getMetaDescription(this);
    if (metaDescription) {
      document.head.innerHTML += '<meta name="description" content="' + metaDescription + '">';
    }
  }

  public getMetaDescription(vm: any) {
    const {metaDescription} = vm;
    if (metaDescription) {
      return typeof metaDescription === 'function'
        ? metaDescription.call(vm)
        : metaDescription;
    }
  }
}
