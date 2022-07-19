<template>
    <div class="container bg-light pb-2">
        <div class="row">
            <div class="col-sm-12">
                <h1> Добавление нового оборудования </h1>
                <button
                    class="btn btn-dark"
                    @click="addRow"
                >
                    Добавить строку +
                </button>

            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-striped text-center table-bordered">
                        <thead>
                        <tr>
                            <th class="col-md-4 align-middle">
                                Тип оборудования
                            </th>
                            <th class="col-md-4  align-middle">
                                Серийный номер
                            </th>
                            <th class="col-md-4 align-middle">
                                Примечание
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr
                            v-for="(item, index) in equipments"
                            :key="index"
                        >
                            <td>
                                <select
                                    v-model="item['equipment_types_id']"
                                    class="p-2 mt-2 mb-2 form-control text-center"
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
                                    min="1"
                                    class="p-2 mt-2 mb-2 text-center form-control"
                                    v-model="item['sn']"
                                >
                            </td>
                            <td>
                                <input
                                    name="note"
                                    type="text"
                                    v-model="item['note']"
                                    class="p-2 mt-2 mb-2 text-center form-control"
                                >
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <button
            v-if="equipments.length !== 0"
            class="btn btn-primary"
            @click="createEquipments"
        >
            Сохранить данные
        </button>
    </div>
</template>

<script>
import Api from "../services/api";

export default {
    data() {
        return {
            equipments: [],
            errors: '',
            equipment_types: {},
        };
    },

    mounted() {
        this.getEquipmentTypesData();
    },

    methods: {
        getEquipmentTypesData() {
            Api.getEquipmentTypeData(localStorage.getItem('access_token'))
                .then((response) => {
                    this.equipment_types = response.data.data;
                })
        },

        addRow() {
            let newData = { equipment_types_id: 1, sn: '', note: ''};
            this.equipments.push(newData);
        },

        createEquipments () {
            this.equipments.forEach((item, index) => {
                if (item.sn.length !== 10) {
                   this.errors += `${index + 1} `
                }
            })

            if (this.errors === '') {
                Api.createEquipmentData({data: this.equipments}, localStorage.getItem('access_token'))
                    .then(() => {
                        this.$notify({
                            type: 'success',
                            text: "Данные нового оборудования успешно сохранены!",
                        });
                        this.$router.go(-1);
                    })
                    .catch(error => {
                        let notificationMessage = '';
                        for (const [key, value] of Object.entries(error.response.data.errors)) {
                            notificationMessage += `${key}: ${value}. \n`
                        }

                        this.$notify({
                            type: 'error',
                            title: "Ошибка сохранения",
                            text: notificationMessage,
                            duration: 10000
                    })
                })
            } else {
                this.$notify({
                    type: 'error',
                    title: "Ошибка",
                    text: `Поле 'Серийный номер' не соответствует нужной длине в строке: ${this.errors}`,
                    duration: 5000
                });

                this.errors = '';
            }
        },
    }
}
</script>
