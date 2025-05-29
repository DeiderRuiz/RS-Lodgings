<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
</script>

<template>
    <div>
        <div class="p-6 lg:p-8 bg-crema border-b border-gray-200">
            <ApplicationLogo class="block w-auto" />

            <h1 class="mt-8 text-2xl font-medium text-black">
                ¡Bienvenido a tu panel de administración!
            </h1>

            <p class="mt-6 text-gris-antracita leading-relaxed">
                En el panel de administración de RS Lodgings, tendrás el control total sobre la gestión de nuestras habitaciones y 
                servicios exclusivos. Desde aquí podrás administrar las habitaciones disponibles, ajustar precios, añadir o quitar 
                servicios y gestionar las solicitudes de los huéspedes. Nuestro sistema intuitivo y fácil de usar te permitirá optimizar 
                la experiencia de tus visitantes, asegurando que cada estadía sea única y memorable. Aprovecha todas las herramientas que 
                te ofrecemos para hacer crecer tu negocio y ofrecer un servicio de calidad excepcional.
            </p>
        </div>

        <div class="bg-crema bg-opacity-40 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">
            <div>
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" class="w-6 h-6 text-gray-400">
                        <path fill="currentColor" d="M7.5 14.885h9v1.057q0 .19.126.317q.126.126.316.126t.317-.126t.126-.317v-3.13q0-.673-.423-1.136t-1.077-.526V9.846q0-.69-.463-1.153t-1.153-.462H9.731q-.69 0-1.153.462t-.462 1.153v1.304q-.656.064-1.078.526t-.422 1.136v3.13q0 .19.125.317q.126.126.317.126q.19 0 .316-.126t.126-.317zm0-.885v-1.188q0-.35.23-.581T8.313 12h7.377q.35 0 .58.23t.231.582V14zM9 11.116V9.73q0-.27.173-.442q.173-.173.443-.173h4.769q.269 0 .442.173T15 9.73v1.385zM4.616 21q-.691 0-1.153-.462T3 19.385V4.615q0-.69.463-1.152T4.615 3h14.77q.69 0 1.152.463T21 4.616v14.769q0 .69-.463 1.153T19.385 21zm0-1h14.769q.23 0 .423-.192t.192-.424V4.616q0-.231-.192-.424T19.385 4H4.615q-.23 0-.423.192T4 4.615v14.77q0 .23.192.423t.423.192M4 20V4z"/>
                    </svg>
                    <h2 class="ms-3 text-xl font-semibold text-black">
                        Habitaciones
                    </h2>
                </div>

                <p class="mt-4 text-gris-marengo text-sm leading-relaxed">
                    Administra fácilmente todas las habitaciones de RS Lodgings desde esta sección. Consulta la disponibilidad, ajusta precios y detalles, y mantén la información siempre actualizada para garantizar una experiencia excepcional a nuestros huéspedes.
                </p>

                <p class="mt-4 text-sm">
                    <a :href="route('admin.rooms.index')" class="inline-flex items-center font-semibold text-rojo-dark">
                        Habitaciones

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="ms-1 w-5 h-5 fill-rojo-dark">
                            <path fill-rule="evenodd" d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </p>
            </div>

            <div>
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" class="w-6 h-6 text-gray-400">
                        <path fill="currentColor" d="M3.73 17.385q-.213 0-.356-.144q-.143-.143-.143-.356q0-.214.143-.357q.143-.144.357-.144h16.538q.214 0 .357.144q.143.143.143.357q0 .213-.143.356q-.143.144-.357.144zM4 15v-.23q0-2.95 2.01-5.103Q8.022 7.516 11 7.097v-.443q0-.402.299-.701q.299-.3.701-.3t.701.3t.299.7v.443q2.985.42 4.992 2.571T20 14.77V15zm1.07-1h13.86q-.234-2.446-2.247-4.204T12 8.04T7.32 9.796T5.07 14M12 14"/>
                    </svg>
                    <h2 class="ms-3 text-xl font-semibold text-vlack">
                        Servicios
                    </h2>
                </div>

                <p class="mt-4 text-gris-marengo text-sm leading-relaxed">
                    Gestiona los servicios exclusivos que ofrecemos en nuestras instalaciones. Desde paquetes de spa hasta servicios de transporte, esta sección te permite añadir, modificar o eliminar servicios para ajustarlos a las necesidades de nuestros visitantes.
                </p>

                <p class="mt-4 text-sm">
                    <a :href="route('admin.services.index')" class="inline-flex items-center font-semibold text-rojo-dark">
                        Servicios

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="ms-1 w-5 h-5 fill-rojo-dark">
                            <path fill-rule="evenodd" d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </p>
            </div>

            <div>
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" class="w-6 h-6 text-gray-400">
                        <g fill="none" stroke="currentColor">
                            <path d="M10.51 3.665a2 2 0 0 1 2.98 0l.7.782a2 2 0 0 0 1.601.663l1.05-.058a2 2 0 0 1 2.107 2.108l-.058 1.049a2 2 0 0 0 .663 1.6l.782.7a2 2 0 0 1 0 2.981l-.782.7a2 2 0 0 0-.663 1.601l.058 1.05a2 2 0 0 1-2.108 2.107l-1.049-.058a2 2 0 0 0-1.6.663l-.7.782a2 2 0 0 1-2.981 0l-.7-.782a2 2 0 0 0-1.601-.663l-1.05.058a2 2 0 0 1-2.107-2.108l.058-1.049a2 2 0 0 0-.663-1.6l-.782-.7a2 2 0 0 1 0-2.981l.782-.7a2 2 0 0 0 .663-1.601l-.058-1.05A2 2 0 0 1 7.16 5.053l1.049.058a2 2 0 0 0 1.6-.663z"/>
                            <path stroke-linejoin="round" stroke-width="1.5" d="M9.5 9.5h.01v.01H9.5zm5 5h.01v.01h-.01z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="m15 9l-6 6"/>
                        </g>
                    </svg>
                    <h2 class="ms-3 text-xl font-semibold text-black">
                        Ofertas
                    </h2>
                </div>

                <p class="mt-4 text-gris-marengo text-sm leading-relaxed">
                    Promociona nuestras mejores ofertas desde esta sección. Define descuentos especiales, paquetes promocionales y asegúrate de que nuestros clientes siempre encuentren la mejor opción para su estadía.
                </p>

                <p class="mt-4 text-sm">
                    <a :href="route('admin.deals.index')" class="inline-flex items-center font-semibold text-rojo-dark">
                        Ofertas

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="ms-1 w-5 h-5 fill-rojo-dark">
                            <path fill-rule="evenodd" d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </p>
            </div>

            <div>
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"  class="w-6 h-6 text-gray-400">
                        <path fill="currentColor" d="M12 19.677q2.82-2.454 4.458-4.991t1.638-4.39q0-2.744-1.737-4.53Q14.62 3.981 12 3.981T7.641 5.766t-1.737 4.53q0 1.852 1.638 4.39T12 19.677m0 .879q-.235 0-.47-.077t-.432-.25q-1.067-.981-2.164-2.185q-1.096-1.203-1.99-2.493t-1.468-2.633t-.572-2.622q0-3.173 2.066-5.234Q9.037 3 12 3t5.03 2.062q2.066 2.061 2.066 5.234q0 1.279-.572 2.613q-.572 1.333-1.458 2.632q-.885 1.3-1.981 2.494T12.92 20.21q-.191.173-.434.26q-.244.086-.487.086m.004-8.825q.667 0 1.14-.476q.472-.475.472-1.143t-.476-1.14t-1.143-.472t-1.14.476t-.472 1.143t.475 1.14t1.144.472"/>
                    </svg>
                    <h2 class="ms-3 text-xl font-semibold text-black">
                        Ubicaciones
                    </h2>
                </div>

                <p class="mt-4 text-gris-marengo text-sm leading-relaxed">
                    Consulta y administra información sobre las diferentes sucursales de RS Lodgings en otras ciudades. Mantén actualizados los datos de contacto, la dirección y las características únicas de cada ubicación para garantizar una experiencia uniforme y de calidad en todas nuestras sedes.
                </p>

                <p class="mt-4 text-sm">
                    <a :href="route('admin.locations.index')" class="inline-flex items-center font-semibold text-rojo-dark">
                        Ubicaciones

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="ms-1 w-5 h-5 fill-rojo-dark">
                            <path fill-rule="evenodd" d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </p>
            </div>

            <div>
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 256 256" class="w-6 h-6 text-gray-400">
                        <path fill="currentColor" d="M112.6 158.43a58 58 0 1 0-57.2 0a93.83 93.83 0 0 0-50.19 38.29a6 6 0 0 0 10.05 6.56a82 82 0 0 1 137.48 0a6 6 0 0 0 10-6.56a93.83 93.83 0 0 0-50.14-38.29M38 108a46 46 0 1 1 46 46a46.06 46.06 0 0 1-46-46m211 97a6 6 0 0 1-8.3-1.74A81.8 81.8 0 0 0 172 166a6 6 0 0 1 0-12a46 46 0 1 0-17.08-88.73a6 6 0 1 1-4.46-11.14a58 58 0 0 1 50.14 104.3a93.83 93.83 0 0 1 50.19 38.29A6 6 0 0 1 249 205"/>
                    </svg>
                    <h2 class="ms-3 text-xl font-semibold text-black">
                        Clientes
                    </h2>
                </div>

                <p class="mt-4 text-gris-marengo text-sm leading-relaxed">
                    Administra la información de nuestros clientes de manera eficiente. Revisa las reservas, historial de estadías y preferencias para ofrecerles un servicio personalizado y fortalecer nuestra relación con ellos.
                </p>

                <p class="mt-4 text-sm">
                    <a :href="route('customers.index')" class="inline-flex items-center font-semibold text-rojo-dark">
                        Clientes

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="ms-1 w-5 h-5 fill-rojo-dark">
                            <path fill-rule="evenodd" d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </p>
            </div>

            <div v-if="$page.props.auth.user.role_id === 1">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" class="w-6 h-6 text-gray-400">
                        <path fill="currentColor" d="M4.616 20q-.691 0-1.153-.462T3 18.384V8.616q0-.691.463-1.153T4.615 7H9V5.615q0-.69.463-1.153T10.616 4h2.769q.69 0 1.153.462T15 5.615V7h4.385q.69 0 1.152.463T21 8.616v9.769q0 .69-.463 1.153T19.385 20zM10 7h4V5.615q0-.23-.192-.423T13.385 5h-2.77q-.23 0-.423.192T10 5.615zm10 7.5h-6v.692q0 .348-.23.578t-.578.23h-2.384q-.348 0-.578-.23t-.23-.578V14.5H4v3.885q0 .23.192.423t.423.192h14.77q.23 0 .423-.192t.192-.424zm-9 .5h2v-2h-2zm-7-1.5h6v-.692q0-.348.23-.578t.578-.23h2.384q.348 0 .578.23t.23.578v.692h6V8.616q0-.231-.192-.424T19.385 8H4.615q-.23 0-.423.192T4 8.616zm8 .5"/>
                    </svg>
                    <h2 class="ms-3 text-xl font-semibold text-black">
                        Empleados
                    </h2>
                </div>

                <p class="mt-4 text-gris-marengo text-sm leading-relaxed">
                    Organiza y supervisa la información de los empleados que forman parte de RS Lodgings. Desde esta sección, puedes gestionar horarios, asignaciones y datos relevantes para asegurar un equipo siempre listo para brindar lo mejor.
                </p>

                <p class="mt-4 text-sm">
                    <a :href="route('employees.index')" class="inline-flex items-center font-semibold text-rojo-dark">
                        Empleados

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="ms-1 w-5 h-5 fill-rojo-dark">
                            <path fill-rule="evenodd" d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </p>
            </div>
        </div>
    </div>
</template>
