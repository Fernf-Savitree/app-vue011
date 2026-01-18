<template>
  <div class="container mt-4">
    <h2 class="mb-3">รายการประเภทสินค้า</h2>
    
    <!-- ตารางแสดงประเภทสินค้า -->
    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>รหัสประเภท</th>
          <th>ชื่อประเภท</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(type) in types" :key="type.Type_ID">
          <td>{{ type.Type_ID }}</td>
          <td>{{ type.Type_name }}</td>
                 </tr>
      </tbody>
    </table>

    <!-- Loading -->
    <div v-if="loading" class="text-center">
      <p>กำลังโหลดข้อมูล...</p>
    </div>

    <!-- Error -->
    <div v-if="error" class="alert alert-danger">
      {{ error }}
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";

export default {
  name: "typeList",
  setup() {
    const types = ref([]);
    const loading = ref(true);
    const error = ref(null);

    // ฟังก์ชันดึงข้อมูลจาก API
    const fetchTypes = async () => {
      try {
        const response = await fetch("http://localhost/app-vue011/php_api/Show_type.php");
        if (!response.ok) {
          throw new Error("ไม่สามารถดึงข้อมูลได้");
        }
        types.value = await response.json();
      } catch (err) {
        error.value = err.message;
      } finally {
        loading.value = false;
      }
    };

    onMounted(() => {
      fetchTypes();
    });

    return {
      types,
      loading,
      error
    };
  }
};
</script>