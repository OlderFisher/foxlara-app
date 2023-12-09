<?php

declare(strict_types=1);
?>
<div class="container">
    <div class="relative right-0">
        <ul
                class="relative flex flex-wrap p-1 list-none bg-blue-gray-50/60 border border-solid border-b-black text-grey-500 font-bold"
                style="border-left: unset;border-right: unset;border-top: unset"
                data-tabs="tabs"
                role="list"
        >
            <li class="z-30 flex-auto text-center">
                <a
                        class="z-30 flex items-center justify-left w-full px-0 py-1 mb-0
                                    border-0 cursor-pointer text-grey-500 bg-inherit hover:text-blue-700"
                        data-tab-target=""
                        active=""
                        role="tab"
                        aria-selected="true"
                        aria-controls="app"
                >
                    <span class="ml-1">Students</span>
                </a>
            </li>
            <li class="z-30 flex-auto text-center">
                <a
                        class="z-30 flex items-center justify-left w-full px-0 py-1 mb-0
                                    border-0  cursor-pointer text-grey-500 bg-inherit hover:text-blue-700"
                        data-tab-target=""
                        role="tab"
                        aria-selected="false"
                        aria-controls="message"
                >
                    <span class="ml-1">Groups</span>
                </a>
            </li>


        </ul>
        <div data-tab-content="" class="p-5">
            <div class="block opacity-100" id="app" role="tabpanel">
                @include('templates.studentsForms')
            </div>
            <div class="hidden opacity-0" id="message" role="tabpanel">
                @include('templates.groupsForms')
            </div>
        </div>
    </div>
</div>
