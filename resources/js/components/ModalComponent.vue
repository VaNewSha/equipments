<template>
    <div
    id="modal"
    class="modal fade"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modalLabel"
    aria-hidden="true"
    >
    <div
      class="modal-dialog modal-dialog-centered"
      role="document"
    >
      <div class="modal-content">
        <div class="modal-header">
          <h5
            id="modalLabel"
            class="modal-title"
          >
            Удаление записи об оборудовании
          </h5>
          <button
            type="button"
            class="close rounded"
            aria-label="Close"
            @click="emitClose"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>
            Вы уверены что хотите удалить запись?
          </p>

        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary"
            @click="emitClose"
          >
            Отмена
          </button>
          <button
            type="submit"
            class="btn btn-danger"
            @click="deleteRecord"
          >
            Удалить
          </button>
        </div>
      </div>
    </div>
    </div>
</template>

<script>
import Api from '../services/api';

export default {

  props: {
    showing: {
      type: Object,
      default: null,
    },
  },

  watch: {
    showing (val) {
      if (val) {
        $('#modal').modal('show');
      } else {
        $('#modal').modal('hide');
      }
    },
  },

  methods: {
    emitClose() {
      this.$emit('close');
    },
    deleteRecord() {
        Api.deleteEquipmentData(this.showing.id).then(() => {
        this.$notify({
            text: "Данные оборудования удалены!",
        });
          this.$emit('close');
        });
    },

  },
};
</script>
