<x-jet-action-section>
    <x-slot name="content">
        <div class="contentTextArea">
            @lang('message.deleteAccountGeneralText')
        </div>

        <div class="buttonArea">
            <x-jet-danger-button  class="generalButton" wire:click="confirmUserDeletion" wire:loading.attr="disabled">
                @lang('message.deleteAccount')
            </x-jet-danger-button>
        </div>

        <!-- Delete User Confirmation Modal -->
        <x-jet-dialog-modal wire:model="confirmingUserDeletion">
            <x-slot name="title">
                @lang('message.deleteAccount')
            </x-slot>

            <x-slot name="content">
                @lang('message.deleteAccountContent')

                <div class="mt-4" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
                    <x-jet-input type="password" class="mt-1 block w-3/4"
                                placeholder="{{__('message.password')}}"
                                x-ref="password"
                                wire:model.defer="password"
                                wire:keydown.enter="deleteUser" />

                    <x-jet-input-error for="password" class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled">
                    @lang('message.cancel')
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="deleteUser" wire:loading.attr="disabled">
                    @lang('message.deleteAccount')
                </x-jet-danger-button>
            </x-slot>
        </x-jet-dialog-modal>
    </x-slot>
</x-jet-action-section>
