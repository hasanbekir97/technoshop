<x-jet-form-section submit="updateProfileInformation">
    <x-slot name="form">
        <div class="inputsArea">
            <!-- Name -->
            <div class="inputArea">
                <label class="block font-medium text-sm text-gray-700" for="name">@lang('message.nameSurname')</label>
                <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name" autocomplete="name" />
                <x-jet-input-error for="name" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="inputArea">
                <label class="block font-medium text-sm text-gray-700" for="email">@lang('message.email')</label>
                <div class="userInformationEmailSection">
                    <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="state.email" />
                    <div id="emailVerificationResult" class="emailVerifiedResultArea">
                    </div>
                </div>
                <x-jet-input-error for="email" class="mt-2" />
            </div>

            <!-- Phone -->
            <div class="inputArea">
                <label class="block font-medium text-sm text-gray-700" for="phone">@lang('message.phone')</label>
                <x-jet-input id="phone" type="number" class="mt-1 block w-full" wire:model.defer="state.phone" />
                <x-jet-input-error for="phone" class="mt-2" />
            </div>
        </div>
    </x-slot>

    <x-slot name="actions">
        <div class="buttonArea">
            <div class="headMessageArea">
                <x-jet-action-message class="mr-3 alertMessageArea" on="saved">
                    @lang('message.informationSaved')
                </x-jet-action-message>
            </div>

            <div class="subButtonArea">
                <x-jet-button class="generalButton" wire:loading.attr="disabled" wire:target="photo">
                    @lang('message.save')
                </x-jet-button>
            </div>
        </div>
    </x-slot>
</x-jet-form-section>
