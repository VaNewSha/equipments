<template>
    <div class="container bg-light">
        <div class="row">
            <div class="col-sm-12">
                <h1> Оборудование </h1>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="d-flex">
                    <div>
                        <router-link
                            class="btn btn-primary"
                            to="/create"
                        >
                            Внести новое
                        </router-link>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-2 row">
            <div class="col-md-12">
                <input
                    id="myInput"
                    v-model="input"
                    class="form-control"
                    type="text"
                    placeholder="Поиск..."
                >
            </div>
        </div>

        <div class="row mt-2">
            <div class="col">
                <div class="table-responsive">
                        <table class="table table-striped text-center table-bordered">
                        <thead>
                        <tr>
                            <th class="col-md-2 align-middle">
                                Код оборудования
                            </th>
                            <th class="col-md-2 align-middle">
                                Тип оборудования
                            </th>
                            <th class="col-md-2 align-middle">
                                Серийный номер
                            </th>
                            <th class="align-middle">
                                Примечание
                            </th>
                            <th class="col-md-1 align-middle">
                                Редактировать
                            </th>
                            <th class="col-md-1 align-middle">
                                Удалить
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr
                            v-for="(item, index) in equipments"
                            :key="index"
                        >
                            <td @click="getEquipment(item['id'])">
                                <input
                                    type="text"
                                    class="p-2 mt-2 mb-2 text-center form-control"
                                    :value="item['id']"
                                    disabled
                                >
                            </td>
                            <td>
                                <select
                                    v-model="item['equipment_types_id']"
                                    class="p-2 mt-2 mb-2 form-control text-center"
                                    :disabled="item['edit'] !== true"
                                >
                                    <option
                                        v-for="(type, index) in equipment_types"
                                        :key="index"
                                        :value="type.id"
                                    >
                                        {{ type.name }}
                                    </option>
                                </select>
                            </td>
                            <td>
                                <input
                                    name="sn"
                                    type="text"
                                    class="p-2 mt-2 mb-2 text-center form-control"
                                    v-model="item['sn']"
                                    :disabled="item['edit'] !== true"
                                >
                            </td>
                            <td>
                                <input
                                    name="note"
                                    type="text"
                                    v-model="item['note']"
                                    class="p-2 mt-2 mb-2 text-center form-control"
                                    :disabled="item['edit'] !== true"
                                >
                            </td>
                            <td>
                                <button
                                    v-if="!item['edit']"
                                    class="form-control p-2 mt-2 mb-2 text-center"
                                    @click="getEditRow(index)"
                                >
                                    <i class="bi bi-pencil-fill" />
                                </button>
                                <button
                                    v-if="item['edit']"
                                    type="submit"
                                    class="form-control p-2 mt-2 mb-2 text-center"
                                    @click="updateEquipmentData(
                                        item['id'], item['equipment_types_id'], item['sn'], item['note'], index
                                        )"
                                >
                                    Сохранить
                                </button>
                            </td>
                            <td>
                                <a
                                    href="#"
                                    class="form-control p-2 mt-2 mb-2 text-center"
                                    @click="modalShowing = {id: item['id']}"
                                >
                                    <i class="bi bi-trash2-fill" />
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <PaginationComponent
                :links="paginationLinks"
                @refreshLinkData="getEquipmentsData"
            />
        </div>

        <ModalComponent
            :showing="modalShowing"
            @close="close"
        />
    </div>
</template>

<script>
import Api from "../services/api";
import ModalComponent from "../components/ModalComponent";
import PaginationComponent from "../components/PaginationComponent";

export default {
    components: {PaginationComponent, ModalComponent},
    data() {
        return {
            equipments: {},
            equipment_types: {},
            paginationLinks: [],
            modalShowing: null,
            filter: '',
            page: 1,
            timeout: null,
        };
    },

    computed: {
        input: {
            get() {
                return this.filter;
            },
            set(val) {
                if (this.timeout) { clearTimeout(this.timeout); }
                this.timeout = setTimeout(() => {
                    if (this.filter !== val) {
                        this.page = 1;
                    }
                    this.filter = val;
                    this.getEquipmentsData(this.page);
                }, 500);
            },
        },
    },

    mounted() {
        this.getEquipmentTypesData();
        this.getEquipmentsData(this.page);
    },

    methods: {
        getEquipmentTypesData() {
            Api.getEquipmentTypeData()
                .then((response) => {
                    this.equipment_types = response.data.data;
                })
        },

        getEquipmentsData(page) {
            this.page = page;
            Api.getEquipmentData( {page, filter: this.filter})
            .then((response) => {
                this.equipments = response.data.data;
                this.paginationLinks = response.data.meta.links;

                for (const [key] of Object.entries(this.equipments)) {
                    this.equipments[key]['edit'] = false;
                }
            })
        },

        getEquipment(id) {
            Api.showEquipmentData(id)
                .then((response) => {
                    let data = response.data.data;
                    let info = `ID: ${data.id}, Type: ${data.equipment_types_id}, Serial number: ${data.sn}`
                    this.$notify({
                        text: info ,
                    });
                })
        },

        updateEquipmentData(id, equipmentTypeId, sn, note, index) {
            if (sn.length === 10) {
                Api.updateEquipmentData(id,
                    {
                        equipmentTypeId: equipmentTypeId,
                        sn: sn,
                        note: note,
                    })
                    .then(() => {
                        this.equipments[index]['edit'] = false;

                        this.$notify({
                            type: 'success',
                            text: "Данные оборудования обновлены!",
                        });
                    })
                    .catch(error => {
                        this.$notify({
                            type: 'error',
                            title: "Ошибка обновления",
                            text: error.response.data.message,
                        });
                    }
                    );
            } else {
                this.$notify({
                    type: 'error',
                    text: `Строка ${index + 1}, ID ${id}: Поле 'Серийный номер' не соответствует нужной длине`,
                });
            }
        },

        getEditRow(index) {
            this.equipments[index]['edit'] = true;
        },

        close() {
            this.modalShowing = null;
            this.getEquipmentsData(this.page);
        },
    }
}
</script>

