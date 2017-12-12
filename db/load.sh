#!/bin/bash

psql -h localhost -d libro -U libro < libro.sql
