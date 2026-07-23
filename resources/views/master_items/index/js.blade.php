<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#table').DataTable({
            searching: false,
            order: [[1, 'desc']],
            columnDefs: [
                { orderable: false, targets: [0, 7, 8] }
            ]
        });
        getData();
    });

    $('.btn-get-data').click(function() {
        getData();
    });

    function getData() {
        $('#loading-filter').show();
        var dataTableObj = $('#table').DataTable();
        var filter_kode      = $('#filter-kode').val();
        var filter_nama      = $('#filter-nama').val();
        var filter_harga_min = $('#filter-harga-min').val();
        var filter_harga_max = $('#filter-harga-max').val();
        dataTableObj.clear().draw();

        $.ajax({
            url: '{{url("master-items/search")}}',
            dataType: 'json',
            tryCount: 0,
            retryLimit: 3,
            data: 'kode=' + filter_kode + '&nama=' + filter_nama + '&hargamin=' + filter_harga_min + '&hargamax=' + filter_harga_max,
            success: function(results) {
                var data = results.data;

                $.each(data, function(index, item) {
                    var foto_html = item.foto
                        ? '<img src="{{ asset("storage") }}/' + item.foto + '" style="height:50px;width:50px;object-fit:cover;" class="rounded">'
                        : '<span class="text-muted small">-</span>';

                    var harga_jual = Math.round(item.harga_beli + item.harga_beli * item.laba / 100);

                    var kategori_html = '';
                    if (item.kategori_items && item.kategori_items.length > 0) {
                        $.each(item.kategori_items, function(i, k) {
                            kategori_html += '<span class="badge bg-secondary me-1">' + k.nama + '</span>';
                        });
                    } else {
                        kategori_html = '<span class="text-muted small">-</span>';
                    }

                    var html = '<a href="{{ url("master-items") }}/' + item.id + '" class="btn btn-primary btn-sm">View</a>';

                    dataTableObj.row.add([
                        foto_html,
                        item.kode,
                        item.nama,
                        item.jenis,
                        item.harga_beli,
                        harga_jual,
                        item.supplier,
                        kategori_html,
                        html
                    ]).draw(true);
                });
                $('#loading-filter').hide();
            },
            error: function(xhr, textStatus, errorThrown) {
                this.tryCount++;
                if (this.tryCount <= this.retryLimit) {
                    $.ajax(this);
                    return;
                }
                alert('Terjadi kesalahan server, tidak dapat mengambil data');
                $('#loading-filter').hide();
            }
        });
    }
</script>