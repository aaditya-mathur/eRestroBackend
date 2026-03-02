<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4> View Order Transaction </h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a class="home_breadcrumb" href="<?= base_url('admin/home') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Order Transaction</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 main-content">
                    <div class="card content-area p-4">
                        <div class="card-innr">
                            <div class="gaps-1-5x"></div>
                            <input type='hidden' id='transaction_user_id' value='<?= (isset($_GET['user_id']) && !empty($_GET['user_id'])) ? $_GET['user_id'] : '' ?>'>
                            <table class='table table-striped' data-toggle="table" data-url="<?= base_url('admin/transaction/view_order_transactions') ?>" data-click-to-select="true" data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true" data-show-refresh="true" data-trim-on-search="false" data-sort-name="id" data-sort-order="desc" data-mobile-responsive="true" data-toolbar="" data-show-export="true" data-maintain-selected="true" data-query-params="transaction_query_params">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true">Id</th>
                                        <th data-field="order_id" data-sortable="false">Order Id</th>
                                        <th data-field="partner_id" data-sortable="false" data-visible="false">Partner Id</th>
                                        <th data-field="partner_name" data-sortable="false">Partner Name</th>
                                        <th data-field="rider_id" data-sortable="false" data-visible="false">Ride Id</th>
                                        <th data-field="rider_name" data-sortable="false">Ride Name</th>
                                        <th data-field="total_amount" data-sortable="false">Total Amount</th>
                                        <th data-field="admin_payment" data-sortable="false">Admin Payment</th>
                                        <th data-field="partner_payment" data-sortable="false">Partner Payment</th>
                                        <th data-field="rider_payment" data-sortable="false">Rider Payment</th>
                                        <th data-field="settelment_status" data-sortable="false">Settelmet Status</th>
                                    </tr>
                                </thead>
                            </table>
                        </div><!-- .card-innr -->
                    </div><!-- .card -->
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<script>

</script>