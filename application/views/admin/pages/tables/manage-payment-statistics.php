<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Payment Statistics</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a class="text text-info"
                                href="<?= base_url('admin/home') ?>"><?= display_breadcrumbs(); ?></a></li>
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
                            <table class='table-striped' data-toggle="table" data-url="<?= base_url('admin/Payment_statistics/view_payment_statistics') ?>" data-side-pagination="server" data-click-to-select="true" data-pagination="true" data-id-field="id" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true" data-show-refresh="true" data-trim-on-search="false" data-sort-name="id" data-sort-order="desc" data-mobile-responsive="true" data-toolbar="#toolbar" data-show-export="true" data-maintain-selected="true" data-export-types='["txt","excel"]' data-query-params="queryParams">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true">ID</th>
                                        <th data-field="order_id" data-sortable="true">Order Id</th>
                                        <th data-field="total_amount" data-sortable="false">Amount</th>
                                        <th data-field="partner_id" data-sortable="true">Partner Id</th>
                                        <th data-field="partner_name" data-sortable="true">Partner Name</th>
                                        <th data-field="rider_id" data-sortable="true">Rider Id</th>
                                        <th data-field="rider_name" data-sortable="true">Rider Name</th>
                                        <th data-field="admin_payment" data-sortable="false">Admin Payment</th>
                                        <th data-field="partner_payment" data-sortable="false">Partner Payment</th>
                                        <th data-field="rider_payment" data-sortable="false">Rider Payment</th>
                                        <th data-field="delivery_tip" data-sortable="false">Delivery Tip</th>
                                        <!-- <th data-field="promo_discount" data-sortable="false">Promocode Discount</th> -->
                                        <th data-field="settelment_status" data-sortable="false">Settelment Status</th>
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