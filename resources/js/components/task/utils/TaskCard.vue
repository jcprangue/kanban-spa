<template>
    <div class="bg-white shadow rounded px-3 pt-3 pb-1 border border-white" :data-tasks-id="task.id">
        <div class="d-flex justify-content-between">
            <p class="text-secondary font-weight-bold">
                {{ task.title }}</router-link>
            </p>

            <img class="rounded" src="/images/user.png" alt="Avatar" width="35" height="35" />
        </div>
        <div class="d-flex mt-2 justify-content-between align-items-center">
            <span class="text-sm text-muted"><i class="icon-calendar"></i> {{ task.date }}</span>
            <badge v-if="task.task_group" :color="badgeColor">{{ task.task_group }}</badge>
        </div>
        <div class="d-flex mt-2 mb-2 justify-content-end align-items-center">
            <router-link :to="{ name: 'Update', params: { id: task.id } }">
                <font-awesome-icon icon="fa-solid fa-pen-to-square" class="mx-2" />
            </router-link>
            <font-awesome-icon icon="fa-solid fa-trash" class="cursor" @click="deleteDialog(task.id)" />
        </div>

    </div>
</template>
<script>
import Badge from "@/components/task/utils/Badge.vue";

export default {
    components: {
        Badge,
    },
    props: {
        task: {
            type: Object,
            default: () => ({}),
        },
    },
    computed: {
        badgeColor() {
            const mappings = {
                Design: "info",
                "Feature Request": "success",
                Backend: "dark",
                QA: "secondary",
                default: "light",
            };
            return mappings[this.task.task_group] || mappings.default;
        },

    },
    methods: {
        deleteDialog(id) {
            const result = confirm("Do you want to delete?");
            if (result) {
                this.$emit("deleteTask", id)
            }
        }

    }
};
</script>
