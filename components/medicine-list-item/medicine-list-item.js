import Component from '/material/script/Component.js';

import MaterialListItem from '/material/components/list-item/material-list-item.js';
import MaterialCheckbox from '/material/components/checkbox/material-checkbox.js';
import MaterialAvatar from '/material/components/avatar/material-avatar.js';

const component = Component.meta(import.meta.url, 'medicine-list-item');
/**
  *
  */
  export default class MedicineListItem extends Component {
  /**
    *
    */
    constructor() {
      super(component);
    }

  /** */
    mount(content) {
      var avatar = content.querySelector('material-avatar');
      avatar.src = this.src;
    }
  }

Component.define(component, MedicineListItem);

// #region [Private]

// #endregion
