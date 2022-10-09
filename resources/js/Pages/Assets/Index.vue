<template>
  <app-layout :title="building.name + '>Assets'" :buildings="$attrs.buildings">

    <!--
    <div
      class="
        flex
        justify-center
        text-gray-500
        bg-gray-200
        py-3
        px-3
        mb-3
        rounded-lg
      "
      v-if="selectAllChecked"
    >
      <div v-if="!selectAllMatchingChecked" class="mr-6">
        {{ resources.data.length }} Assets on this page have been selected.
      </div>

      <div v-else class="mr-6">
        {{ resources.total }} Assets have been selected.
      </div>

      <label class="flex items-center select-none">
        <input
          type="checkbox"
          class="mr-2"
          :checked="selectAllMatchingChecked"
          @change="toggleSelectAllMatching"
        />
        <div>
          <span v-if="!selectAllMatchingChecked" class="text-blue-700">
            Select All {{ resources.total }} Assets
          </span>
          <span v-else class="text-blue-700"> Cancel selection </span>
        </div>
      </label>
    </div>
    -->
    <Table
      :filters="queryBuilderProps.filters"
      :search="queryBuilderProps.search"
      :columns="queryBuilderProps.columns"
      :on-update="setQueryBuilder"
      :meta="resources"
    >
      <template #buttonCreate>
        <InertiaLink class="ah-btn-1" as="button" :href="route('buildings.assets.create', building.id)">Create Asset</InertiaLink>
      </template>
      <template #head>
        <tr>
          <!--<th>
            <input
              type="checkbox"
              class="checked"
              :checked="selectAllChecked"
              @input="toggleSelectAll"
            />
          </th>-->
          <th @click.prevent="sortBy('id')">Id</th>
          <th @click.prevent="sortBy('name')">Name</th>
          <th @click.prevent="sortBy('description')">Descritpion</th>
          <th @click.prevent="sortBy('status')">Status</th>
          <th>Actions</th>
        </tr>
      </template>

      <template #body>
        <tr v-for="asset in resources.data" :key="asset.id">
          <!--<td>
            <input
              type="checkbox"
              :checked="selectedResources.indexOf(asset) > -1"
              :value="asset.id"
              @change="updateSelectionStatus(asset)"
            />
          </td>-->
          <td>{{ asset.id }}</td>
          <td>{{ asset.name }}</td>
          <td>{{ truncate(asset.description) }}</td>
          <td>
            <template v-if="asset.status">Enabled</template>
            <template v-else>Disabled</template>
          </td>
          <td>
            <InertiaLink class="ah-btn-1" as="button" :href="route('buildings.assets.edit', [building.id, asset.id])">Edit</InertiaLink>
          </td>
        </tr>
      </template>
    </Table>
  </app-layout>
</template>

<script>
import { InteractsWithQueryBuilder } from "@protonemedia/inertiajs-tables-laravel-query-builder";
import AppLayout from "@/Shared/AppLayout.vue";
import Table from "@/Tailwind2/Table";

export default {
  mixins: [InteractsWithQueryBuilder],

  components: {
    AppLayout,
    Table,
  },

  props: ["resources", "building"],

  data() {
    return {
      selectedResources: [],
      selectAllMatchingResources: false,
    };
  },

  computed: {
    selectAllChecked() {
      return this.selectedResources.length == this.$props.resources.data.length;
    },

    selectAllMatchingChecked() {
      return (
        this.selectedResources.length == this.$props.resources.data.length &&
        this.selectAllMatchingResources
      );
    },
  },

  methods: {
    redirect(event) {
      window.location.href = route(
        "buildings.assets.index",
        event.target.value
      );
    },

    truncate(text) {
      text = _.truncate(text, { length: 100 });
      return text;
    },

    /** Selected all */

    toggleSelectAllMatching() {
      if (!this.selectAllMatchingResources) {
        this.selectAllResources();
        this.selectAllMatchingResources = true;
        return;
      }

      this.selectAllMatchingResources = false;
    },

    selectAllResources() {
      this.selectedResources = this.$props.resources.data.slice(0);
    },

    toggleSelectAll(event) {
      if (this.selectAllChecked) {
        return this.clearResourceSelections();
      }

      this.selectAllResources();
    },

    clearResourceSelections() {
      this.selectAllMatchingResources = false;
      this.selectedResources = [];
    },

    updateSelectionStatus(resource) {
      this.selectAllMatchingResources = false;

      if (!_(this.selectedResources).includes(resource)) {
        return this.selectedResources.push(resource);
      }

      const index = this.selectedResources.indexOf(resource);
      if (index > -1) return this.selectedResources.splice(index, 1);
    },
  },
};
</script>