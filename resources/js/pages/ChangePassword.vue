<template>
    <main>
        <div class="box_template">
            <section class="p-0">
                <div class="box_top mb-0">
                    <div class="container">
                        <h2 class="title mb-3">パスワード設定</h2>
                    </div>
                </div>
            </section>

            <section class="section_pass">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <form action="" class="frm_settingpass" autocomplete="off">
                                <div class="form-group">
                                    <label for="">パスワード（英数字８文字以上）</label>
                                    <input
                                        type="password"
                                        class="form-control"
                                        v-model="password"
                                        placeholder="パスワードを確認する"
                                        :class="{
                                            'is-invalid':
                                                (submitted && $v.password.$error) ||
                                                (errorsApi.password && errorsApi.password.length)
                                        }"
                                    />
                                    <div v-if="submitted && $v.password.$error" class="invalid-feedback">
                                        <span v-if="!$v.password.required">パスワードを入力してください </span>
                                        <span v-if="!$v.password.minLength">
                                            パスワードは8～16文字以内で指定してください
                                        </span>
                                    </div>
                                    <div
                                        v-else-if="errorsApi.password && errorsApi.password.length"
                                        class="invalid-feedback"
                                    >
                                        <span>
                                            {{ errorsApi.password[0] }}
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">パスワード（再入力）</label>
                                    <input
                                        type="password"
                                        class="form-control"
                                        placeholder="パスワードを確認する"
                                        v-model="password_confirmation"
                                        :class="{
                                            'is-invalid':
                                                (submitted && $v.password_confirmation.$error) ||
                                                (errorsApi.password_confirmation &&
                                                    errorsApi.password_confirmation.length)
                                        }"
                                    />
                                    <div
                                        v-if="errorsApi.password_confirmation && errorsApi.password_confirmation.length"
                                        class="invalid-feedback"
                                    >
                                        <span>
                                            {{ errorsApi.password_confirmation[0] }}
                                        </span>
                                    </div>
                                    <div v-if="submitted && $v.password_confirmation.$error" class="invalid-feedback">
                                        <span v-if="!$v.password_confirmation.required"
                                            >パスワードを入力してください</span
                                        >
                                        <span v-else-if="!$v.password_confirmation.minLength">
                                            パスワードが一致しません
                                        </span>
                                    </div>
                                </div>
                                <button type="button" class="btn btn_register" :disabled="disabled" @click="submit()">
                                    保存
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
</template>
<script>
import { required, sameAs, minLength, maxLength, requiredIf } from 'vuelidate/lib/validators';
import Vue from 'vue';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.all.min.js';

Vue.use(VueSweetalert2);

export default {
    validations: {
        password: {
            required,
            minLength: minLength(8),
            maxLength: maxLength(255)
        },
        password_confirmation: {
            required: requiredIf(function() {
                return this.password;
            }),
            sameAs: sameAs(function() {
                return this.password;
            })
        }
    },
    data() {
        return {
            errorsApi: {},
            password: '',
            password_confirmation: '',
            submitted: false,
            disabled: false
        };
    },
    methods: {
        submit() {
            this.submitted = true;
            this.$v.$touch();
            this.errorsApi = {};
            if (!this.$v.$invalid && this.submitted) {
                this.submitted = false;
                this.disabled = true;

                var content = 'パスワードが正常に変更されました！';
                let data = {
                    password: this.password,
                    password_confirmation: this.password_confirmation
                };

                this.$store
                    .dispatch('changePassword', data)
                    .then(resp => {
                        this.$swal('パスワード変更', content, 'success').then(result => {
                            if (result.isConfirmed) {
                                this.$router.push({ name: 'information' }).catch(() => {});
                            }
                        });
                    })
                    .catch(err => {
                        this.disabled = false;
                        this.submitted = false;
                        this.errorsApi = err.response.data.errors.messages[0];
                    });
            }
        }
    }
};
</script>
