<template>
  <div class="container mt-4">
    <h2 class="mb-3">ประเภทสินค้า</h2>
    
    <div class="mb-3">
      <button class="btn btn-primary" @click="openAddModal">
        Add <i class="bi bi-plus-circle"></i>
      </button>
    </div>

    <table class="table table-bordered table-striped">
      <thead class="table-primary">
        <tr>
          <th>รหัสประเภท</th>
          <th>ชื่อประเภท</th>
          <th>แก้ไข/ลบ</th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="type in types" :key="type.Type_ID">
          <td>{{ type.Type_ID }}</td>
          <td>{{ type.Type_name }}</td>
         
          <td>
            <button class="btn btn-warning btn-sm" @click="openEditModal(type)">
              แก้ไข
            </button>
            |
            <button class="btn btn-danger btn-sm" @click="deleteType(type.Type_ID)">
              ลบ
            </button>
            </td>
        </tr>
      </tbody>
    </table>

    <div v-if="loading" class="text-center"><p>กำลังโหลดข้อมูล...</p></div>
    <div v-if="error" class="alert alert-danger">{{ error }}</div>

    <!-- ✅ Modal ใช้ทั้งเพิ่ม/แก้ไข -->
    <div class="modal fade" id="editModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ isEditMode ? "แก้ไขข้อมูลประเภทสินค้า" : "เพิ่มประเภทสินค้าใหม่" }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="saveType">
              <div class="mb-3">
                <label class="form-label">ประเภทสินค้า</label>
                <input v-model="editTypes.Type_name" type="text" class="form-control" required>
              </div>

                <button type="submit" class="btn btn-success">
                {{ isEditMode ? "บันทึกการแก้ไข" : "เพิ่มประเภทสินค้า" }}
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
import { ref, onMounted } from "vue";

export default {
  name: "TypeList",
  setup() {
    const types = ref([]);
    const loading = ref(true);
    const error = ref(null);
    const editTypes = ref({});
    const isEditMode = ref(false);
    let editModal = null;

    const fetchTypes = async () => {
      try {
        const response = await fetch("http://localhost/app-vue011/php_api/type_crud.php");
        const result = await response.json();

        if (result.success) {
          types.value = result.data;
        } else {
          error.value = result.message;
        }
      } catch (err) {
        error.value = err.message;
      } finally {
        loading.value = false;
      }
    };

    onMounted(() => {
      fetchTypes();
      const modalEl = document.getElementById("editModal");
      editModal = new window.bootstrap.Modal(modalEl);
    });

    // ✅ เปิด Modal เพิ่มประเภทสินค้า
    const openAddModal = () => {
      isEditMode.value = false;
      editTypes.value = {
        Type_name: ""
      };
      editModal.show();
    };

    // ✅ เปิด Modal แก้ไขประเภทสินค้า
    const openEditModal = (type) => {
      isEditMode.value = true;
      editTypes.value = { ...type };
      editModal.show();
    };

    // ✅ ใช้ฟังก์ชันเดียวสำหรับทั้งเพิ่ม/แก้ไข
    const saveType = async () => {
      const url = "http://localhost/app-vue011/php_api/type_crud.php";
      const method = isEditMode.value ? "PUT" : "POST";

      try {
        const response = await fetch(url, {
          method,
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(editTypes.value)
        });

        const result = await response.json();

        if (result.success) {
          alert(result.message);
          fetchTypes();
          editModal.hide();
        } else {
          alert(result.message);
        }
      } catch (err) {
        alert("เกิดข้อผิดพลาด: " + err.message);
      }
    };

    // ✅ ลบประเภทสินค้า
    const deleteType = async (id) => {
      if (!confirm("คุณต้องการลบข้อมูลนี้ใช่หรือไม่?")) return;
      try {
        const response = await fetch("http://localhost/app-vue011/php_api/type_crud.php", {
          method: "DELETE",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ Type_ID: id })
        });
        const result = await response.json();
        if (result.success) {
          types.value = types.value.filter(c => c.Type_ID !== id);
          alert(result.message);
        } else {
          alert(result.message);
        }
      } catch (err) {
        alert("เกิดข้อผิดพลาด: " + err.message);
      }
    };

    return {
      types,
      loading,
      error,
      editTypes,
      isEditMode,
      openAddModal,
      openEditModal,
      saveType,
      deleteType
    };
  }
};
</script>