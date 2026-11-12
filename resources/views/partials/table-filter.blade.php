{{--
    Client-side status tabs + optional search for a [data-filter-table] card.
    Rows need data-status="pending|approved|rejected"; searchable rows add data-search="...".
--}}
<script>
    document.querySelectorAll('[data-filter-table]').forEach(function (card) {
        var tabs = card.querySelectorAll('[data-filter]');
        var rows = card.querySelectorAll('tbody tr[data-status]');
        var emptyRow = card.querySelector('[data-empty-filter]');
        var search = card.querySelector('[data-search-input]');
        var shown = card.querySelector('[data-shown-count]');
        var current = 'all';

        function apply() {
            var term = search ? search.value.trim().toLowerCase() : '';
            var visible = 0;

            rows.forEach(function (row) {
                var statusOk = current === 'all' || row.dataset.status === current;
                var searchOk = !term || (row.dataset.search || '').indexOf(term) !== -1;
                row.hidden = !(statusOk && searchOk);
                if (!row.hidden) visible++;
            });

            if (emptyRow) emptyRow.hidden = rows.length === 0 || visible > 0;
            if (shown) shown.textContent = 'Showing ' + visible + ' of ' + rows.length;
        }

        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                current = tab.dataset.filter;
                tabs.forEach(function (t) { t.setAttribute('aria-selected', t === tab ? 'true' : 'false'); });
                apply();
            });
        });

        if (search) search.addEventListener('input', apply);
    });
</script>