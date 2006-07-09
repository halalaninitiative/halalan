<h2>Steps</h2>
<p>
{if $MODULE_NAME|lower eq "ballot"}
>>
{/if}
Vote
</p>

<p>&nbsp;
{if $MODULE_NAME|lower eq "candidateinfo"}
>>
{/if}
Candidate Info
</p>

<p>&nbsp;
{if $MODULE_NAME|lower eq "partyinfo"}
>>
{/if}
Party Info
</p>

<p>
{if $MODULE_NAME|lower eq "confirmvote"}
>>
{/if}
Confirm Vote
</p>

<p>
{if $MODULE_NAME|lower eq "success"}
>>
{/if}
Success
</p>