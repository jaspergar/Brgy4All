<template lang="">
    <div>
        <div v-if="$store.state.user">
            <!-- <div> -->
            <!--========== ADMIN SIDE MENU one ========-->
            <div class="_1side_menu">
                <div class="_1side_menu_logo">
                    <!-- <h3 style="text-align:center;">Logo Image</h3> -->
                    <img
                        src="/images/brgy4allLogo.png"
                        style="width: 108px;margin-left: 68px;"
                    />
                </div>

                <!--~~~~~~~~ MENU CONTENT ~~~~~~~~-->
                <div class="_1side_menu_content">
                    <div class="_1side_menu_img_name">
                        <!-- <img class="_1side_menu_img" src="/pic.png" alt="" title=""> -->
                        <p class="_1side_menu_name">Barangay Admin</p>
                    </div>

                    <!--~~~ MENU LIST ~~~~~~-->
                    <div class="_1side_menu_list">
                        <ul class="_1side_menu_list_ul">
                            <!-- <li><router-link to="/"><Icon type="md-home" /> Overview</router-link></li> -->
                            <li>
                                <router-link to="/"
                                    ><Icon type="md-contacts" />Barangay
                                    Workers</router-link
                                >
                            </li>
                            <li>
                                <router-link to="/citizens"
                                    ><Icon type="ios-people" />Barangay
                                    Citizens</router-link
                                >
                            </li>
                            <li>
                                <router-link to="/services"
                                    ><Icon
                                        type="ios-construct"
                                    />Services</router-link
                                >
                            </li>
                            <li>
                                <router-link to="/announcements"
                                    ><Icon
                                        type="md-megaphone"
                                    />Announcements</router-link
                                >
                            </li>
                            <li><a href="/logout"><Icon type="ios-speedometer" /> Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--========== ADMIN SIDE MENU ========-->

            <!--========= HEADER ==========-->
            <div class="header">
                <div class="_2menu _box_shadow">
                    <div class="_2menu_logo">
                        <ul class="open_button">
                            <li>
                                <Icon type="ios-list" />
                            </li>
                            <!--<li><Icon type="ios-albums" /></li>-->
                        </ul>
                    </div>
                </div>
            </div>
            <!--========= HEADER ==========-->
        </div>
        <router-view />
    </div>
</template>
<script>
export default {
    props: ["user"],
    data() {
        return {
            isLoggedIn: false
        };
    },
    created() {
         this.$store.dispatch('updateUserAction',this.user)
    }
};
</script>
<style lang=""></style>
