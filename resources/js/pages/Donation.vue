<template>
    <transition name="el-fade-in-linear">
        <el-card>
            <h4>DONASI</h4>
            <hr>
            <el-form :inline="true" style="text-align:right;">
                <el-form-item>
                    <el-select class="pager-options" v-model="pageSize" placeholder="Page Size">
                        <el-option v-for="item in $store.state.pagerOptions" :key="item.value" :label="item.label" :value="item.value"> </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item style="margin-right:0;">
                    <el-input placeholder="Search" prefix-icon="el-icon-search" v-model="keyword">
                        <el-button @click="refreshData" slot="append" icon="el-icon-refresh"></el-button>
                    </el-input>
                </el-form-item>
            </el-form>

            <el-table :data="paginatedData.data" stripe
            :default-sort = "{prop: 'updated_at', order: 'descending'}"
            v-loading="loading"
            style="border-top:1px solid #eee;"
            @filter-change="filterChange"
            @sort-change="sortChange">
                <el-table-column type="index" width="50" :index="paginatedData.from"> </el-table-column>
                <el-table-column prop="updated_at" label="Waktu" sortable="custom"></el-table-column>
                <el-table-column prop="user" label="Donatur" sortable="custom"></el-table-column>
                <el-table-column prop="program" label="Program" sortable="custom"></el-table-column>
                <el-table-column prop="package" label="Paket" sortable="custom"></el-table-column>
                <el-table-column prop="remark" label="Keterangan" sortable="custom"></el-table-column>
                <el-table-column prop="payment_method" label="Metode Pembayaran" sortable="custom"></el-table-column>
                <el-table-column prop="amount" label="Jumlah" sortable="custom" align="right" header-align="right">
                    <template slot-scope="scope">
                        Rp {{ scope.row.amount | formatNumber }}
                    </template>
                </el-table-column>
                <el-table-column prop="status" label="Status" sortable="custom" align="right" header-align="right"></el-table-column>
            </el-table>

            <br>

            <el-row>
                <el-col :span="12">
                    <el-pagination @current-change="goToPage"
                        :page-size="pageSize"
                        background
                        layout="prev, pager, next"
                        :total="paginatedData.total">
                    </el-pagination>
                </el-col>
                <el-col :span="12" style="text-align:right">
                    {{ paginatedData.from }} - {{ paginatedData.to }} of {{ paginatedData.total }} items
                </el-col>
            </el-row>

        </el-card>
    </transition>
</template>

<script>
export default {
    watch: {
        keyword: function(v, o) {
            this.requestData()
        },
        pageSize: function(v, o) {
            this.requestData()
        }
    },
    data: function() {
        return {
            loading: false,
            showForm: false,
            formTitle: '',
            formErrors: {},
            error: {},
            formModel: {},
            keyword: '',
            page: 1,
            pageSize: 10,
            sort: 'updated_at',
            order: 'descending',
            filters: {},
            paginatedData: {}
        }
    },
    methods: {
        sortChange: function(column) {
            if (this.sort !== column.prop || this.order !== column.order) {
                this.sort = column.prop;
                this.order = column.order;
                this.requestData();
            }
        },
        filterChange: function(f) {
            let column = Object.keys(f)[0];
            this.filters[column] = Object.values(f[column]);
            this.refreshData();
        },
        goToPage: function(p) {
            this.page = p;
            this.requestData();
        },
        refreshData: function() {
            this.keyword = '';
            this.page = 1;
            this.requestData();
        },
        requestData: function() {
            let params = {
                page: this.page,
                keyword: this.keyword,
                pageSize: this.pageSize,
                sort: this.sort,
                order: this.order,
            }
            this.loading = true;

            axios.get(BASE_URL + '/donation', {params: Object.assign(params, this.filters)})
                .then(r => {
                    this.loading = false;
                    this.paginatedData = r.data
                })
                .catch(e => {
                    this.loading = false;
                    this.$message({
                        message: e.response.data.message || e.response.message,
                        type: 'error'
                    });
                })
        }
    },
    created: function() {
        this.requestData();
    }
}
</script>

<style lang="css" scoped>
</style>
