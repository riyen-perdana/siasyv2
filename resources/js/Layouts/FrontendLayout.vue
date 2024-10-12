<template>
    <div class="flex flex-col justify-between min-h-screen bg-background" >
        <header class="sticky top-0 z-50 border-b bg-background/80 backdrop-blur-lg border-border">
            <div class="container flex flex-row items-center justify-between h-20 max-w-screen-xl">
                <slot name="header"></slot>
            </div>
        </header>
        <section name="content" class="container max-w-screen-xl mx-auto">
            <slot></slot>
        </section>
        <section name="footer" class="sticky bottom-0 z-50 border-t bg-background/80 backdrop-blur-lg border-border">
            <div class="container flex items-center h-10 max-w-screen-xl">
                <slot name="footer"></slot>
            </div>
        </section>
    </div>
</template>
