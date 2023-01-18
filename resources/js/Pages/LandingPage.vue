<template>

    <section class="full-page flex justify-center md:justify-between  " id="home">
        <div class="hidden md:flex flex-col animate-fade-in-down">
            <nav class=" navbar flex  p-7  antialiased font-sans">

                <div class="hidden md:flex space-x-6 text-white">
                    <a href="#home" class="m-4 my-3 rounded-lg text-xl">Home</a>
                    <a class=" m-4 my-3 rounded-lg text-xl">Services</a>
                    <a href="#rdrrmc" class="m-2 my-3 rounded-lg text-xl">About</a>
                    <a href="#contact" class="m-4 my-3 rounded-lg text-xl">Contact</a>
                </div>
            </nav>
        </div>


        <div class="flex m-2 py-10 bg-white animate-fade-in-down">

            <form class="flex flex-col   pt-0 px-14 pb-2 font-sans" @submit.prevent="submit">

                <div class="flex flex-col space-y-10">
                    <h1 class="font-extrabold text-transparent text-center bg-clip-text bg-gradient-to-r from-orange-600 to-pink-400"
                    style="font-family:Courier; font-size: 3rem;">Login</h1>
                <h4 v-if="!$page.props.auth.user"
                    class="font-extrabold text-transparent text-center bg-clip-text bg-gradient-to-r from-orange-600 to-pink-400"
                    style="font-family:Courier; font-size: 2rem;">Log in to EPRRIS</h4>
                </div>
              


                <div class="flex flex-col space-y-10">
                    <div class="relative flex flex-col z-0  " v-if="!$page.props.auth.user">
                        <InputLabel for="email" value="email" />
                        <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required
                            autofocus autocomplete="username" />

                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>
                    <div class="relative flex flex-col z-0  pb-10 space-y-2 " v-if="!$page.props.auth.user">
                        <div class="flex justify-between">
                            <!-- <label for="password" class="text-sm font-bold">Password</label> -->
                            <InputLabel for="password" value="Password" />
                            <a class="text-sm font-bold cursor-pointer" :class="showpassword ? 'text-blue-500' : ''"
                                type="button" @click="showpassword = !showpassword">show</a>
                        </div>


                        <TextInput id="password" :type="showpassword ? 'text' : 'password'" class="mt-1 block w-full"
                            v-model="form.password" required autocomplete="current-password" />
                        <InputError class="mt-2" :message="form.errors.password" />
                        <!-- <input v-if="showpassword" name="password" type="text" v-model="form.password"
                        class="border-2 bg-transparent focus:outline-none focus:ring-0 py-2 px-1" />
                    <input v-else name="password" type="password" v-model="form.password"
                        class="border-2 bg-transparent focus:outline-none focus:ring-0 py-2 px-1" /> -->

                    
                      
                    
                    </div>
                    <div class="flex flex-col">
                        <button v-if="!$page.props.auth.user" type="submit" class=" text-white bg-orange-700 hover:bg-orange-800 focus:ring-4 
                        focus:ring-orange-300 font-medium text-sm px-5 py-2.5 mx-5 mb-2 
                        dark:bg-orange-600 dark:hover:bg-orange-700 focus:outline-none dark:focus:ring-orange-800">Sign
                        in</button>
                        <inertia-link :href="route('register')" class="tex-lg text-orange-400 underline text-center font-semibold">
                            Register Here
                        </inertia-link>
                    </div>
                  
                        
                   
                </div>

            </form>

        </div>

    </section>
    <!-- RDRRMC -->
    <div class="body">
        <section class="flex flex-col p-16 py-4 md:py-16 h-fit md:h-screen" id="rdrrmc">
            <div class="px-10 py-4">
                <h1 class="font-semibold text-black text-4xl antialiased">RDRRMC</h1>
            </div>
            <div class="grid  md:grid-cols-2 gap-11 justify-evenly">
                <div class="text-center">
                    <img :src="'landingpage/binan.jpg'" class="border-transparent rounded-md drop-shadow-lg">
                </div>
                <div class="text-center">
                    <p class="font-semibold text-justify pb-5">Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                        Sint
                        nulla iure maiores, sed praesentium
                        error voluptates velit optio tempore accusamus, sequi accusantium quis cumque in corporis
                        ratione
                        odit cum dolore.
                        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sint nulla iure maiores, sed
                        praesentium
                        error voluptates velit optio tempore accusamus, sequi accusantium quis cumque in corporis
                        ratione
                        odit cum dolore.</p>
                    <p class="font-semibold text-justify">Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                        Harum, sequi ipsa! Nostrum optio quo sint tempora illo accusamus quisquam fugiat vitae soluta
                        consequatur, assumenda ex harum architecto eligendi cupiditate adipisci!</p>
                    <a type="button" href="#provinces" class="mt-10 w-full  py-3 border-2 rounded-3xl border-black ">
                        <h3 class="text-black font-semibold">Provinces</h3>
                    </a>
                </div>
            </div>
        </section>
        <!-- Provinces -->

        <section class=" h-fit md:h-screen " id="provinces">
            <h1 class="text-center font-bold text-2xl">Provinces</h1>

            <div class="flex flex-col md:flex-row justify-evenly py-10 space-y-9 md:space-x-9">
                <div class="grid grid-rows-1 place-items-center">

                    <img :src="'landingpage/logos/Mis_Occ.svg'" class=" w-24">

                    <span class="text-xl font-semibold p-0 text-black">Province of Misamis Occidental</span>
                    <span class=" font-semibold p-0 text-slate-700">Orogueta City</span>

                </div>
                <div class="grid grid-rows-1 place-items-center">
                    <img :src="'landingpage/logos/Camiguin_Seal.png'" class=" w-24">
                    <span class="text-xl font-semibold p-0 text-black">Province of Camiguin</span>
                    <span class=" font-semibold p-0 text-slate-700">Mambajao</span>
                </div>
                <div class="grid grid-rows-1 place-items-center">
                    <img :src="'landingpage/logos/PGLDN-LOGO.png'" class=" w-28">
                    <span class="text-xl font-semibold p-0 text-black">Province of Lanao Del Norte</span>
                    <span class=" font-semibold p-0 text-slate-700">Tubod</span>
                </div>
            </div>
            <div class="flex flex-col md:flex-row space-y-9 md:space-x-9 justify-evenly md:pt-16">
                <div class="grid grid-rows-1 place-items-center">
                    <img :src="'landingpage/logos/Ph_seal_bukidnon.png'" class=" w-24">
                    <span class="text-xl font-semibold p-0 text-black">Province of Bukidnon</span>
                    <span class=" font-semibold p-0 text-slate-700">Malaybalay City</span>
                </div>
                <div class="grid grid-rows-1 place-items-center">
                    <img :src="'landingpage/logos/Ph_seal_misamis_oriental.2.png'" class=" w-24">
                    <span class="text-xl font-semibold p-0 text-black">Province of Misamis Oriental</span>
                    <span class=" font-semibold p-0 text-slate-700">Cagayan De Oro City</span>
                </div>
            </div>
        </section>
        <!-- contact us  -->
        <section class=" h-fit md:h-screen" id="contact">
            <div class="flex flex-col space-y-11 justify-center">
                <div class="flex flex-col space-y-3 text-center">
                    <h1 class="text-2xl font-bold font-serif">Contact Us</h1>
                    <span class="text-md font-sans px-10 text-justify">Lorem, ipsum dolor sit amet consectetur
                        adipisicing
                        elit. Corporis quae porro eaque
                        quisquam esse recusandae distinctio iste, suscipit minus laboriosam, alias repellendus
                        voluptatum
                        beatae
                        voluptate reiciendis ipsum deleniti. Voluptatibus, assumenda?</span>
                </div>

                <div class="flex flex-col md:flex-row-reverse space-y-2 md:px-16 md:gap-56">
                    <!-- card -->
                    <div class="flex flex-col self-center w-4/5 bg-white px-10 py-16
                     drop-shadow-xl space-y-12 contact h-full">
                        <h2 class="font-bold text-3xl pt-5">Send Message</h2>
                        <!-- <form class="px-5" @submit.prevent="submit">
                            <div class="relative z-0 mb-6 w-full group">
                                <input type="text" name="full_name" id="floating_email" v-model="form.fullName"
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-black appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " required />
                                <label for="full_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 
                                duration-300 transform -translate-y-6 scale-75 top-3 -z-10 
                                origin-[0] peer-focus:left-0 peer-focus:text-blue-600 
                                peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 
                                peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                    Full Name</label>
                            </div>
                            <div class="relative z-0 mb-6 w-full group">
                                <input type="email" name="email" id="email" v-model="form.email"
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-black appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " required />
                                <label for="email" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 
                                duration-300 transform -translate-y-6 scale-75 top-3 -z-10 
                                origin-[0] peer-focus:left-0 peer-focus:text-blue-600 
                                peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 
                                peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                    Email</label>
                            </div>
                            <div class="relative z-0 mb-6 w-full group">
                                <textarea type="password" name="floating_password" id="floating_password"
                                    v-model="form.message"
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-black appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " required />
                                <label for="floating_password" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 
                                duration-300 transform -translate-y-6 scale-75 top-3 -z-10 
                                origin-[0] peer-focus:left-0 peer-focus:text-blue-600 
                                peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 
                                peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                    Message</label>
                            </div>
                            <button type="submit" class="mt-5 rounded-md bg-blue-500 px-6 py-2">Send</button>

                        </form> -->
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-1 self-center md:self-stretch w-4/5 py-20  text-center">

                        <span class="text-xs md:text-lg antialiased text-gray-500">
                            <i class="fa-solid fa-envelope pr-1 md:text-xl"></i>Canaresmiko3@gmail.com</span>

                        <span class="text-xs md:text-lg antialiased text-gray-500">
                            <i class="fa-solid fa-phone-flip pr-1 md:text-xl"></i>223-3321 / +639533221805</span>

                        <span class="text-xs  md:text-lg antialiased col-span-2 md:col-span-1 text-gray-500 pl-1">
                            <i class="fa-solid fa-location-dot pr-1 md:text-xl"></i>Pedro Pagalan St. Poblacion, Naawan,
                            9023
                            Misamis oriental</span>

                    </div>

                </div>

            </div>


        </section>
        <section class="h-fit md:h-screen">
            <h1 class="py-10 px-20 font-bold text-4xl">Lead government agencies and their response cluster</h1>
            <div class="grid grid-rows-1 md:grid-cols-3 gap-2  ">
                <div class="grid grid-rows-1 place-items-center py-10" v-for="(agency, index) in agencies" :key="index">

                    <img :src="agency.img" class=" w-24">

                    <span class="text-lg font-semibold p-0 text-black text-center">{{ agency.name }}</span>
                    <span class=" font-semibold p-0 text-slate-700">{{ agency.text }}</span>

                </div>
            </div>



        </section>

    </div>



</template>

<script>
import { useForm } from '@inertiajs/inertia-vue3';
import AFP from '../../../public/landingpage/logos/agencies/AFP.png';
import DILG from '../../../public/landingpage/logos/agencies/DILG.png'
import DOH from '../../../public/landingpage/logos/agencies/DOH.png'
import OCD from '../../../public/landingpage/logos/agencies/OCD.png'
import PNP from '../../../public/landingpage/logos/agencies/PNP.png'


import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref } from 'vue';
export default {
    components: {
        TextInput,
        InputLabel,
        InputError

    },
    setup() {
        const showpassword = ref(false)
        const form = useForm({
            email: '',
            password: '',
            remember: false
        });

        const submit = () => {
            form.post(route('login'), {
                onFinish: () => form.reset('password'),
            });
        };
        // const form = useForm({
        //     fullName: '',
        //     email: '',
        //     message: '',
        // })

        // const submit = () => {
        //     console.log(form)
        // }
        const agencies = [
            {
                name: 'Armed Forces of the Philippines (AFP)',
                text: 'Search, Rescue, and Retrieval',
                img: AFP,
            },
            {
                name: 'Department of Interior and Local Government (DILG)',
                text: 'Management of the dead and missing',
                img: DILG
            },
            {
                name: 'Department of Health (DOH)',
                text: 'Wash, Health, Nutrition and  Psychological Services',
                img: DOH
            },
            {
                name: 'Office of Civil Defense (OCD)',
                text: 'Logistics and Emergency Telecommunications',
                img: OCD
            },
            {
                name: 'Philippine National Police (PNP)',
                text: 'Law and Order',
                img: PNP
            },



        ]
        return {
            showpassword,
            agencies,
            submit,
            form,
        }
    }
}
</script>

<style scoped>
.full-page {
    background-image: linear-gradient(rgba(0, 0, 0, 0.7),
            rgba(0, 0, 0, 0.1)), url('landingpage/loginbackground.png');
    height: 100vh;
    background-size: cover;
    background-position: center;
}

.body {
    background-color: #e2e8f0;
}

.contact {
    border: 1px;
    border-radius: 75px;
}
</style>