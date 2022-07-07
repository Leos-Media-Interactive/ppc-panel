<div class="form-control w-full max-w-xs mb-3">
    <label class="label">
        <span class="label-text">תקופה</span>
    </label>
    <select class="select select-bordered" id="range-controller" data-route="{{ $content }}">
        <option value="TODAY" @selected($range === 'TODAY')>היום</option>
        <option value="YESTERDAY" @selected($range === 'YESTERDAY')>אתמול</option>
        <option value="THIS_WEEK_SUN_TODAY" @selected($range === 'THIS_WEEK_SUN_TODAY')>מתחילת השבוע</option>
        <option value="LAST_WEEK_SUN_SAT" @selected($range === 'LAST_WEEK_SUN_SAT')>שבוע שעבר</option>
        <option value="LAST_7_DAYS" @selected($range === 'LAST_7_DAYS')>7 ימים אחרונים</option>
        <option value="LAST_14_DAYS" @selected($range === 'LAST_14_DAYS')>14 ימים אחרונים</option>
        <option value="LAST_30_DAYS" @selected($range === 'LAST_30_DAYS')>30 הימים האחרונים</option>
        <option value="THIS_MONTH" @selected($range === 'THIS_MONTH')>החודש</option>
        <option value="LAST_MONTH" @selected($range === 'LAST_MONTH')>חודש קודם</option>
    </select>
</div>
