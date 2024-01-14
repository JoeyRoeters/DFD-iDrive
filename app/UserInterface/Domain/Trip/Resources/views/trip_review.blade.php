<div class="col-11 mx-auto">
    <div class="card mt-2">
        <div class="row">
            <div class="col-3 border-right">
                <select id="chart_type" class="form-control">
                    <option selected="selected" value="speed">Speed</option>
                    <option value="speed_braking">Speed & Braking</option>
                </select>
            </div>
            <div class="col-9">
                <div id="unloadedChart"></div>
                <div class="m-auto text-center p-10" id="loading">
                    <i class="fa-regular fa-spin fa-2xl fa-spinner-scale"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.onload = function () {
        window.$(document).ready(function () {
            // Functie om AJAX-oproep uit te voeren
            function loadChart(selectedChart) {
                $.ajax({
                    url: '{{route("trip.show.review.graph", ['id' => $trip->id])}}',
                    type: 'GET',
                    data: {graph: selectedChart},
                    before: function () {
                        $('#unloadedChart').html("");
                        $('#loading').show();
                    },
                    success: function (data) {
                        $('#unloadedChart').html(data);
                        $('#loading').hide();
                    },
                    error: function (error) {
                        console.error("Er is een fout opgetreden: ", error);
                    }
                });
            }

            $('#chart_type').on('change', function () {
                var selectedChart = $(this).val();
                loadChart(selectedChart);
            });

            var selectedChart = $('#chart_type').val();
            loadChart(selectedChart);
        });
    }
</script>



