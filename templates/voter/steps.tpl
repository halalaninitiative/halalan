<h2>Steps</h2>
<p>
{if $MODULE_NAME|lower eq "ballot"}
&raquo;
{/if}
Vote
</p>

<p>&nbsp;
{if $MODULE_NAME|lower eq "candidateinfo"}
&raquo;
{/if}
Candidate Info
</p>

<p>&nbsp;
{if $MODULE_NAME|lower eq "partyinfo"}
&raquo;
{/if}
Party Info
</p>

<p>
{if $MODULE_NAME|lower eq "confirmvote"}
&raquo;
{/if}
Confirm Vote
</p>

<p>
{if $MODULE_NAME|lower eq "success"}
&raquo;
{/if}
Success
</p>