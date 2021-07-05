<template>
    <div>
        <main id="main">
            <div class="box_template">
                <section class="p-0">
                    <div class="box_top mb-0">
                        <div class="container">
                            <h2 class="title mb-3">ようこそ</h2>
                            <p class="subtitle mb-2">
                                <small>ご登録完成いたしまた。<br>
                                下のボタンを押してログインしましょう。</small>
                            </p>
                        </div>
                    </div>
                </section>
                <section class="section_pass">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-lg-12">
                                <router-link class="btn btnsave" :to="{ name: 'login' }">
                                        ログイン
                                </router-link>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>
</template>
