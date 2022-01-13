<?php

function enterpriseId()
{
    return auth()->user() ? auth()->user()->usenterpriseid : 0;
}
