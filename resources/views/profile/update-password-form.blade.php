<x-jet-form-section submit="updatePassword">
    <x-slot name="form">
        <div class="inputsArea">

            <!-- current password -->
            <div class="inputArea">
                <label class="block font-medium text-sm text-gray-700" for="current_password">@lang('message.currentPassword')</label>
                <x-jet-input id="current_password" type="password" class="mt-1 block w-full" wire:model.defer="state.current_password" autocomplete="current-password" />
                <x-jet-input-error for="current_password" class="mt-2" />
            </div>

            <!-- new password -->
            <div class="inputArea">
                <label class="block font-medium text-sm text-gray-700" for="password">@lang('message.newPassword')</label>
                <x-jet-input id="password" type="password" class="mt-1 block w-full" wire:model.defer="state.password" autocomplete="new-password" />
                <x-jet-input-error for="password" class="mt-2" />
            </div>

            <!-- confirm password -->
            <div class="inputArea">
                <label class="block font-medium text-sm text-gray-700" for="password_confirmation">@lang('message.confirmNewPassword')</label>
                <x-jet-input id="password_confirmation" type="password" class="mt-1 block w-full" wire:model.defer="state.password_confirmation" autocomplete="new-password" />
                <x-jet-input-error for="password_confirmation" class="mt-2" />
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
                <x-jet-button class="generalButton">
                    @lang('message.save')
                </x-jet-button>
            </div>
        </div>
    </x-slot>
</x-jet-form-section>
