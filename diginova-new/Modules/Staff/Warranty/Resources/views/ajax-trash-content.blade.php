<div class="js-table-container">
    <div style="margin-top: 20px; margin-bottom: 20px;"></div>
    <div class="c-grid__row">
        <div class="c-grid__col">
            <div class="c-card">
                <div class="c-card__wrapper">
                    <div class="c-card__header c-card__header--table">
                        <div class="c-grid__col c-grid__col--lg-4">
                            <a href="{{ route('staff.warranties.index') }}" class="c-ui-btn js-view-all-orders">بازگشت به صفحه مدیریت گارانتی‌ها</a>
                        </div>
                        <div class="c-ui-paginator js-paginator">
                            <div class="c-ui-paginator__total" data-rows="۶">
                                تعداد نتایج: <span name="total" data-id="{{ $warranties->total() }}">{{ persianNum($warranties->total()) }} مورد</span>
                            </div>
                        </div>
                    </div>
                    <div class="c-card__body c-ui-table__wrapper">
                        <table class="c-ui-table js-search-table js-table-fixed-header c-join__table"
                               data-search-url="/ajax/product/search/">
                            <thead>
                            <tr class="c-ui-table__row">
                                <th class="c-ui-table__header"><span
                                        class="table-header-searchable uk-text-nowrap "> ردیف </span>
                                </th>
                                <th class="c-ui-table__header"><span
                                        class="table-header-searchable uk-text-nowrap table-header-searchable--desc">نام گارانتی</span>
                                </th>
                                <th class="c-ui-table__header"><span
                                        class="table-header-searchable uk-text-nowrap "> گروه کالایی </span>
                                </th>
                                <th class="c-ui-table__header"><span
                                        class="table-header-searchable uk-text-nowrap ">تعداد تنوع</span>
                                </th>
                                <th class="c-ui-table__header"><span
                                        class="table-header-searchable uk-text-nowrap ">عملیات</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody id="tbody">
                            @foreach($warranties as $key => $warranty)
                                <tr name="row" id="{{$warranty->id}}" class="c-ui-table__row c-ui-table__row--body c-join__table-row">
                                    <td class="c-ui-table__cell">
                                        <span class="c-wallet__body-card-row-item"> {{ persianNum($warranties->firstItem() + $key) }} </span>
                                    </td>
                                    <td class="c-ui-table__cell c-ui-table__cell-desc c-ui--pt-15 c-ui--pb-15">
                                        <div class="uk-flex uk-flex-column">
                                            <a href="#" target="_blank">
                                                <span class="c-wallet__body-card-row-item c-ui--fit c-ui--initial">
                                                    @if($warranty->month !== null)
                                                      {{ 'گارانتی ' . persianNum($warranty->month) . ' ' . ' ماهه ' . $warranty->name  }}
                                                    @else
                                                      {{ 'گارانتی ' . $warranty->name  }}
                                                    @endif
                                                    @if($warranty->type == 1)
                                                      <span style="color: red; font-size: 11px;"> (ویژه) </span>
                                                    @endif
                                                </span>
                                                <span class="c-wallet__body-card-row-item c-ui--fit c-ui--initial"></span>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="c-ui-table__cell">
                                        <a href="#">
                                            <div class="uk-flex uk-flex-column">
                                              <span class="c- -card-row-item" style="line-height: 23px;">
                                                  @foreach($warranty->categories as $category)
                                                      {{ $category->name }}&nbsp;<br>
                                                  @endforeach
                                              </span>
                                            </div>
                                        </a>
                                    </td>

                                    <td class="c-ui-table__cell">
                                      <span class="c-wallet__body-card-row-item"> {{ persianNum($warranty->product_variants->count()) }} </span>
                                    </td>

                                    <td class="c-ui-table__cell">
                                        <div class="c-promo__actions">
                                            <button class="c-join__btn c-join__btn--icon-right c-join__btn--secondary-greenish restore-btn"
                                                    value="{{ $warranty->id }}">بازگردانی</button>

                                            <button class="c-join__btn c-join__btn--icon-right c-join__btn--icon-delete
                                                              c-join__btn--primary js-remove-plp js-remove-product-list delete-btn"
                                                    value="{{ $warranty->id }}">حذف کامل</button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            @include('staffwarranty::layouts.modal')
                            </tbody>
                        </table>
                    </div>
                    <div class="c-card__footer" style="width: auto;">
                        <a href="{{ route('staff.warranties.index') }}" class="c-ui-btn js-view-all-orders">بازگشت به صفحه مدیریت گارانتی‌ها</a>

                        {{ $warranties->links('staffwarranty::layouts.pagination.pagination') }}

                        <div class="c-ui-paginator js-paginator">
                            <div class="c-ui-paginator__total" data-rows="۶">
                                تعداد نتایج: <span name="total" data-id="{{ $warranties->total() }}">{{ persianNum($warranties->total()) }} مورد</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>