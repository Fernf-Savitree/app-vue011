<template>
  <div class="container mt-4">
    <h2 class="mb-3">แสดงข้อมูลสินค้า</h2>
    

     <div class="mb-3 text-start">
      <a class="btn btn-primary" href="/add_customer" role="button">Add+</a>
    </div>
    <!-- ตารางแสดงข้อมูลลูกค้า -->
    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>ลำดับที่</th>
          <th>รหัสสินค้า</th>
          <th>ชื่อสินค้า</th>
          <th>รายละเอียด</th>
          <th>ราคา</th>
          <th>จำนวน</th>
          <th>รูปภาพ</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(data,index) in Alldata" :key="data.product_id">
          <td>{{ index + 1 }}</td>   <!--แสดงลำดับที่-->
          <td>{{ data.product_id }}</td>
          <td>{{ data.product_name }}</td>
          <td>{{ data.description }}</td>
          <td>{{ data.price }}</td>
          <td>{{ data.stock }}</td>
         <td>
        <img
            :src="'http://localhost/app-vue011/php_api/image/' + data.image"
            width="150"
            height="150" >
          </td>
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
  name: "DataList",
  setup() {
    const Alldata = ref([]);
    const loading = ref(true);
    const error = ref(null);

    // ฟังก์ชันดึงข้อมูลจาก API
    const fetchData = async () => {
      try {
        const response = await fetch("http://localhost/app-vue011/php_api/show_product.php");
        if (!response.ok) {
          throw new Error("ไม่สามารถดึงข้อมูลได้");
        }
        Alldata.value = await response.json();
      } catch (err) {
        error.value = err.message;
      } finally {
        loading.value = false;
      }
    };

    onMounted(() => {
      fetchData();
    });

    return {
      Alldata,
      loading,
      error
    };
  }
};
</script>