<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { onMounted, onBeforeUnmount } from 'vue';

import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import Card from '@/components/ui/card/Card.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import Button from '@/components/ui/button/Button.vue';
import { dashboard } from '@/routes';
import { usePage } from '@inertiajs/vue3';
import { loadMercadoPago } from '@mercadopago/sdk-js';

const page = usePage();

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Dashboard',
                href: dashboard(),
            },
        ],
    },
});

const props = defineProps<{
    preference: string;
    publicKey: string;
}>();

let brickController: { unmount: () => void } | undefined;

onMounted(async () => {
    try {
        await loadMercadoPago();

        const MercadoPago = (window as any).MercadoPago;

        const mp = new MercadoPago(props.publicKey, {
            locale: 'es-AR',
        });

        brickController = await mp
            .bricks()
            .create('wallet', 'wallet_container', {
                initialization: {
                    preferenceId: props.preference,
                },
            });
    } catch (error) {
        console.error('Error al inicializar Mercado Pago:', error);
    }
});

onBeforeUnmount(() => {
    brickController?.unmount();
});
</script>

<template>
    <Head title="Dashboard" />

    <div
        class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
    >
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
            >
                <PlaceholderPattern />
            </div>
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
            >
                <PlaceholderPattern />
            </div>
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
            >
                <PlaceholderPattern />
            </div>
        </div>
        <div class="relative min-h-screen flex-1 rounded-xl md:min-h-min">
            <Card>
                <CardContent class="flex flex-col items-center p-4">
                    <div class="mt-2 text-2xl font-bold">
                        Monto a pagar 100$
                    </div>

                    <!-- <Button class="px-4 py-2 rounded my-4 flex cursor-pointer w-60">
                        <img src="/logos/mp_logo.png" alt="Mercado Pago" class="h-10 object-cover" />
                    </Button> -->

                    <div id="wallet_container"></div>
                </CardContent>
            </Card>
        </div>
    </div>
</template>
